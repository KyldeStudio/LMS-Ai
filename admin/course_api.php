<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../include/db_connect.php';

function ensure_tables($conn){
    $queries = [];
    $queries[] = "CREATE TABLE IF NOT EXISTS course (\n        id INT AUTO_INCREMENT PRIMARY KEY,\n        course_title VARCHAR(255) NOT NULL\n    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $queries[] = "CREATE TABLE IF NOT EXISTS chapters (\n        id INT AUTO_INCREMENT PRIMARY KEY,\n        course_id INT NOT NULL,\n        chapter_title VARCHAR(255) NOT NULL,\n        chapter_order INT DEFAULT 0,\n        FOREIGN KEY (course_id) REFERENCES course(id) ON DELETE CASCADE\n    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $queries[] = "CREATE TABLE IF NOT EXISTS lessons (\n        id INT AUTO_INCREMENT PRIMARY KEY,\n        chapter_id INT NOT NULL,\n        title VARCHAR(255) NOT NULL,\n        description TEXT,\n        lesson_order INT DEFAULT 0,\n        FOREIGN KEY (chapter_id) REFERENCES chapters(id) ON DELETE CASCADE\n    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $queries[] = "CREATE TABLE IF NOT EXISTS lesson_blocks (\n        id INT AUTO_INCREMENT PRIMARY KEY,\n        lesson_id INT NOT NULL,\n        type ENUM('title','text','video') NOT NULL,\n        content TEXT,\n        block_order INT DEFAULT 0,\n        FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE\n    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    foreach($queries as $q){
        $conn->query($q);
    }
}

ensure_tables($conn);

// Parse input (JSON preferred)
$input = file_get_contents('php://input');
$data = json_decode($input, true);
if(!is_array($data)){
    // fallback to POST/REQUEST
    $data = $_POST;
}

$action = isset($data['action']) ? $data['action'] : (isset($_REQUEST['action']) ? $_REQUEST['action'] : '');

function fail($msg){ echo json_encode(['success'=>false,'error'=>$msg]); exit; }

if($action === 'create_chapter'){
    $course_id = isset($data['course_id']) ? intval($data['course_id']) : 0;
    $title = isset($data['title']) ? trim($data['title']) : '';
    if($course_id <= 0) fail('Invalid course id');
    if($title === '') fail('Title required');

    // determine order
    $res = $conn->query("SELECT COALESCE(MAX(chapter_order),0) as mo FROM chapters WHERE course_id = " . intval($course_id));
    $row = $res->fetch_assoc();
    $order = intval($row['mo']) + 1;

    $stmt = $conn->prepare("INSERT INTO chapters (course_id, chapter_title, chapter_order) VALUES (?, ?, ?)");
    $stmt->bind_param('isi', $course_id, $title, $order);
    if(!$stmt->execute()){
        fail('Insert failed: ' . $stmt->error);
    }
    $id = $stmt->insert_id;
    echo json_encode(['success'=>true,'chapter_id'=>$id,'chapter_title'=>$title]);
    exit;
}

if($action === 'update_course_title'){
    $course_id = isset($data['course_id']) ? intval($data['course_id']) : 0;
    $title = isset($data['title']) ? trim($data['title']) : '';
    if($course_id <= 0) fail('Invalid course id');
    if($title === '') fail('Title required');

    $stmt = $conn->prepare("UPDATE course SET course_title = ? WHERE id = ?");
    $stmt->bind_param('si', $title, $course_id);
    if(!$stmt->execute()){
        fail('Update failed: ' . $stmt->error);
    }
    echo json_encode(['success'=>true,'course_title'=>$title]);
    exit;
}

if($action === 'update_chapter'){
    $chapter_id = isset($data['chapter_id']) ? intval($data['chapter_id']) : 0;
    $title = isset($data['title']) ? trim($data['title']) : '';
    if($chapter_id <= 0) fail('Invalid chapter id');
    if($title === '') fail('Title required');

    $stmt = $conn->prepare("UPDATE chapters SET chapter_title = ? WHERE id = ?");
    $stmt->bind_param('si', $title, $chapter_id);
    if(!$stmt->execute()){
        fail('Update failed: ' . $stmt->error);
    }
    echo json_encode(['success'=>true,'chapter_id'=>$chapter_id,'chapter_title'=>$title]);
    exit;
}

if($action === 'delete_chapter'){
    $chapter_id = isset($data['chapter_id']) ? intval($data['chapter_id']) : 0;
    if($chapter_id <= 0) fail('Invalid chapter id');

    $stmt = $conn->prepare("DELETE FROM chapters WHERE id = ?");
    $stmt->bind_param('i', $chapter_id);
    if(!$stmt->execute()){
        fail('Delete failed: ' . $stmt->error);
    }
    echo json_encode(['success'=>true,'chapter_id'=>$chapter_id]);
    exit;
}

if($action === 'create_lesson'){
    $chapter_id = isset($data['chapter_id']) ? intval($data['chapter_id']) : 0;
    $title = isset($data['title']) ? trim($data['title']) : '';
    $description = isset($data['description']) ? trim($data['description']) : '';
    if($chapter_id <= 0) fail('Invalid chapter id');
    if($title === '') fail('Title required');

    $res = $conn->query("SELECT COALESCE(MAX(lesson_order),0) as mo FROM lessons WHERE chapter_id = " . intval($chapter_id));
    $row = $res->fetch_assoc();
    $order = intval($row['mo']) + 1;

    $stmt = $conn->prepare("INSERT INTO lessons (chapter_id, title, description, lesson_order) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('issi', $chapter_id, $title, $description, $order);
    if(!$stmt->execute()) fail('Insert failed: ' . $stmt->error);
    $id = $stmt->insert_id;
    echo json_encode(['success'=>true,'lesson_id'=>$id,'title'=>$title,'description'=>$description]);
    exit;
}

if($action === 'update_lesson'){
    $lesson_id = isset($data['lesson_id']) ? intval($data['lesson_id']) : 0;
    $title = isset($data['title']) ? trim($data['title']) : '';
    $description = isset($data['description']) ? trim($data['description']) : '';
    if($lesson_id <= 0) fail('Invalid lesson id');
    if($title === '') fail('Title required');

    $stmt = $conn->prepare("UPDATE lessons SET title = ?, description = ? WHERE id = ?");
    $stmt->bind_param('ssi', $title, $description, $lesson_id);
    if(!$stmt->execute()) fail('Update failed: ' . $stmt->error);
    echo json_encode(['success'=>true,'lesson_id'=>$lesson_id,'title'=>$title,'description'=>$description]);
    exit;
}

if($action === 'delete_lesson'){
    $lesson_id = isset($data['lesson_id']) ? intval($data['lesson_id']) : 0;
    if($lesson_id <= 0) fail('Invalid lesson id');

    $stmt = $conn->prepare("DELETE FROM lessons WHERE id = ?");
    $stmt->bind_param('i', $lesson_id);
    if(!$stmt->execute()) fail('Delete failed: ' . $stmt->error);
    echo json_encode(['success'=>true,'lesson_id'=>$lesson_id]);
    exit;
}

if($action === 'update_chapter_order'){
    $order = isset($data['order']) && is_array($data['order']) ? $data['order'] : [];
    if(empty($order)) fail('Order required');
    $stmt = $conn->prepare("UPDATE chapters SET chapter_order = ? WHERE id = ?");
    foreach($order as $i => $id){
        $idx = intval($i) + 1;
        $cid = intval($id);
        $stmt->bind_param('ii', $idx, $cid);
        $stmt->execute();
    }
    echo json_encode(['success'=>true]);
    exit;
}

if($action === 'update_lesson_order'){
    $chapter_id = isset($data['chapter_id']) ? intval($data['chapter_id']) : 0;
    $order = isset($data['order']) && is_array($data['order']) ? $data['order'] : [];
    if($chapter_id <= 0) fail('Invalid chapter id');
    if(empty($order)) { echo json_encode(['success'=>true]); exit; }
    $stmt = $conn->prepare("UPDATE lessons SET lesson_order = ? WHERE id = ? AND chapter_id = ?");
    foreach($order as $i => $id){
        $idx = intval($i) + 1;
        $lid = intval($id);
        $stmt->bind_param('iii', $idx, $lid, $chapter_id);
        $stmt->execute();
    }
    echo json_encode(['success'=>true]);
    exit;
}

// Unknown action
fail('Unknown action');
