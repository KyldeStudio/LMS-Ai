<?php
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

// Ensure there is at least one course (single-course app)
$res = $conn->query("SELECT * FROM course LIMIT 1");
if($res && $res->num_rows > 0){
    $course = $res->fetch_assoc();
} else {
    $conn->query("INSERT INTO course (course_title) VALUES ('My Course')");
    $course = ['id' => $conn->insert_id, 'course_title' => 'My Course'];
}

// Load chapters and lessons for the course
$chapters = [];
$stmt = $conn->prepare("SELECT id, chapter_title FROM chapters WHERE course_id = ? ORDER BY chapter_order, id");
$stmt->bind_param('i', $course['id']);
$stmt->execute();
$result = $stmt->get_result();
while($row = $result->fetch_assoc()){
    $chapter = ['id' => $row['id'], 'title' => $row['chapter_title'], 'lessons' => []];

    $ls = $conn->prepare("SELECT id, title FROM lessons WHERE chapter_id = ? ORDER BY lesson_order, id");
    $ls->bind_param('i', $row['id']);
    $ls->execute();
    $res2 = $ls->get_result();
    while($r2 = $res2->fetch_assoc()){
        $chapter['lessons'][] = ['id' => $r2['id'], 'title' => $r2['title']];
    }
    $ls->close();

    $chapters[] = $chapter;
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management - LMS for Ai</title>
    <link rel="stylesheet" href="../dist/style.css">
    <link rel="stylesheet" href="../public/gen.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
</head>
<body class="bg-[#121212] text-white">
    <section class="ml-[400px] mt-10 max-w-7xl ">
        <!-- Title -->
        <div class="flex items-center gap-4">
            <h1 class="text-2xl font-bold" id="courseTitle"><?= htmlspecialchars($course['course_title']) ?></h1>
            <button id="editCourseBtn" class="text-sm text-gray-300 border rounded px-2 py-1">Edit</button>
        </div>
        <h1 class="text-xl font-bold mt-4">Course Structure</h1>
        <h3 class="text-[#9c9c9c]">Here your can update your course structure.</h3>
        <!-- Chapters -->
        <div class="flex flex-row justify-between items-center p-8 border rounded-t-lg bg-[#1e1e1e] mt-6">
            <h2 class="text-xl font-bold">Chapters</h2>
            <button id="btnNewChapter" class="btn btn-primary cursor-pointer">New Chapter</button>
        </div>
        <!-- Lessons and Chapters List -->
   <div id="chapters" class=" space-y-5  mx-auto py-4 px-8 border rounded-b-lg bg-[#1e1e1e]">

        <?php foreach ($chapters as $chapter): ?>
        <div class="bg-transparent border  shadow-lg shadow-[rgba(0,0,0,0.2)] rounded-lg p-5" data-id="<?= $chapter['id'] ?>">
            
            <!-- CHAPTER HEADER -->
            <div class="flex  justify-between items-center my-2">
                <h3 class=" text-l font-semibold flex items-center gap-2 cursor-move">
                    ☰ <?= $chapter['title'] ?>
                </h3>

                <div class="space-x-2 flex flex-row justify-center ">
                    <button class="edit-chapter-btn cursor-pointer border rounded bg-[#636FF2] border-white" data-chapter-id="<?= $chapter['id'] ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><g data-name="Layer 2"><circle cx="256" cy="256" r="256" fill="transparent" opacity="1" data-original="#26a1f4"></circle><g fill="#fff"><path d="m345.15 237.54-.14-.14-70.56-70.61s-86 86-127.44 128.3c-5.16 5.26-9.07 12.58-11.39 19.66-6.8 20.79-12.43 42-18.69 63-1.68 5.63-1.34 10.59 3.07 14.79 4.16 4 8.84 4.14 14.24 2.52 20-6 40.13-11.71 60.22-17.46a61.5 61.5 0 0 0 27.16-16.39c39.48-39.72 123.53-123.67 123.53-123.67zM386.34 149.81l-24.13-24.13a33 33 0 0 0-46.65 0L288.21 153 359 223.81l27.35-27.35a33 33 0 0 0-.01-46.65z" fill="#ffffff" opacity="1" data-original="#ffffff"></path></g></g></g></svg> 
                    </button>
            <button class="delete-chapter-btn cursor-pointer bg-[#ff0000] border-white border rounded " data-chapter-id="<?= $chapter['id'] ?>">                               
               <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" x="0" y="0" viewBox="0 0 173.397 173.397" style="enable-background:new 0 0 512 512" xml:space="preserve" fill-rule="evenodd" class=""><g><circle cx="86.699" cy="86.699" r="84.667" fill="transparent" opacity="1" data-original="#db4437" class=""></circle><g fill="#fff"><path d="m122.819 67.955-6.586 66.354c-.376 3.783-3.256 6.818-7.059 6.818H64.223c-3.802 0-6.683-3.033-7.058-6.818l-6.587-66.354zM71.052 81.06a3.538 3.538 0 0 1 3.334-3.718 3.538 3.538 0 0 1 3.719 3.333l2.275 41.735a3.476 3.476 0 0 1-2.12 3.432c-1.381.599-2.912.291-3.954-.796a3.515 3.515 0 0 1-.978-2.247l-2.276-41.74zm27.96-3.718a3.549 3.549 0 0 1 3.333 3.718l-2.275 41.734a3.476 3.476 0 0 1-2.479 3.18 3.476 3.476 0 0 1-3.844-1.216 3.516 3.516 0 0 1-.73-2.344l2.276-41.739a3.538 3.538 0 0 1 3.718-3.333z" fill="#ffffff" opacity="1" data-original="#ffffff" class=""></path><rect width="86.35" height="12.415" x="43.524" y="53.122" rx="6.207" fill="#ffffff" opacity="1" data-original="#ffffff" class=""></rect><path d="M108.151 53.726h-6.18v-7.94c0-4.035-3.3-7.336-7.335-7.336H78.762c-4.035 0-7.336 3.3-7.336 7.336v7.94h-6.18v-7.94c0-7.446 6.07-13.516 13.515-13.516h15.875c7.445 0 13.515 6.07 13.515 13.515z" fill="#ffffff" opacity="1" data-original="#ffffff" class=""></path></g></g></svg>
            </button>
                </div>
            </div>

            <hr class="my-3 border-gray-300">

            <!-- LESSONS -->
            <ul class="lesson-list space-y-4  " id="chapter-<?= $chapter['id'] ?>">

                <?php foreach ($chapter['lessons'] as $lesson): ?>
                <li class="bg-[#2e2e2e] shadow-lg shadow-[rgba(0,0,0,0.2)] hover:bg-[#3e3e3e] p-3 rounded flex justify-between items-center cursor-move " data-id="<?= $lesson['id'] ?>">
                    <span>☰ <?= $lesson['title'] ?></span>
                    <div class="flex flex-row justify-center space-x-2 ">
                        <button class="edit-lesson-btn cursor-pointer border rounded bg-[#636FF2] border-white" data-lesson-id="<?= $lesson['id'] ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><g data-name="Layer 2"><circle cx="256" cy="256" r="256" fill="transparent" opacity="1" data-original="#26a1f4"></circle><g fill="#fff"><path d="m345.15 237.54-.14-.14-70.56-70.61s-86 86-127.44 128.3c-5.16 5.26-9.07 12.58-11.39 19.66-6.8 20.79-12.43 42-18.69 63-1.68 5.63-1.34 10.59 3.07 14.79 4.16 4 8.84 4.14 14.24 2.52 20-6 40.13-11.71 60.22-17.46a61.5 61.5 0 0 0 27.16-16.39c39.48-39.72 123.53-123.67 123.53-123.67zM386.34 149.81l-24.13-24.13a33 33 0 0 0-46.65 0L288.21 153 359 223.81l27.35-27.35a33 33 0 0 0-.01-46.65z" fill="#ffffff" opacity="1" data-original="#ffffff"></path></g></g></g></svg> 
                        </button>
                        <button class="delete-lesson-btn bg-[#ff0000] border-white border rounded cursor-pointer" data-lesson-id="<?= $lesson['id'] ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" x="0" y="0" viewBox="0 0 173.397 173.397" style="enable-background:new 0 0 512 512" xml:space="preserve" fill-rule="evenodd" class=""><g><circle cx="86.699" cy="86.699" r="84.667" fill="transparent" opacity="1" data-original="#db4437" class=""></circle><g fill="#fff"><path d="m122.819 67.955-6.586 66.354c-.376 3.783-3.256 6.818-7.059 6.818H64.223c-3.802 0-6.683-3.033-7.058-6.818l-6.587-66.354zM71.052 81.06a3.538 3.538 0 0 1 3.334-3.718 3.538 3.538 0 0 1 3.719 3.333l2.275 41.735a3.476 3.476 0 0 1-2.12 3.432c-1.381.599-2.912.291-3.954-.796a3.515 3.515 0 0 1-.978-2.247l-2.276-41.74zm27.96-3.718a3.549 3.549 0 0 1 3.333 3.718l-2.275 41.734a3.476 3.476 0 0 1-2.479 3.18 3.476 3.476 0 0 1-3.844-1.216 3.516 3.516 0 0 1-.73-2.344l2.276-41.739a3.538 3.538 0 0 1 3.718-3.333z" fill="#ffffff" opacity="1" data-original="#ffffff" class=""></path><rect width="86.35" height="12.415" x="43.524" y="53.122" rx="6.207" fill="#ffffff" opacity="1" data-original="#ffffff" class=""></rect><path d="M108.151 53.726h-6.18v-7.94c0-4.035-3.3-7.336-7.335-7.336H78.762c-4.035 0-7.336 3.3-7.336 7.336v7.94h-6.18v-7.94c0-7.446 6.07-13.516 13.515-13.516h15.875c7.445 0 13.515 6.07 13.515 13.515z" fill="#ffffff" opacity="1" data-original="#ffffff" class=""></path></g></g></svg>
                        </button>
                    </div>
                </li>
                <?php endforeach; ?>

            </ul>

            <button class="create-lesson-btn mt-4 w-full bg-[#2e2e2e] py-2 rounded cursor-pointer border border-gray-300  hover:bg-[#3e3e3e]" data-chapter-id="<?= $chapter['id'] ?>">Create New Lesson</button>
        </div>
        <?php endforeach; ?>

    </div>

    <!-- Edit Course Modal -->
    <div id="editCourseModal" class="hidden fixed inset-0 z-50 items-center justify-center">
        <div id="editModalOverlay" class="absolute inset-0 bg-black opacity-60"></div>
        <div class="relative bg-[#141414] rounded-lg w-full max-w-md p-6 z-50 border border-gray-700">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-xl font-bold">Edit Course Name</h2>
                </div>
                <button id="editModalClose" class="text-gray-300 hover:text-white ml-4 cursor-pointer">✕</button>
            </div>
            <div class="mt-4">
                <input id="courseNameInput" type="text" placeholder="Course name" class="w-full px-3 py-2 rounded bg-[#1e1e1e] border border-gray-600 text-white" value="<?= htmlspecialchars($course['course_title']) ?>" />
            </div>
            <div class="mt-6 flex justify-end">
                <button id="saveCourseBtn" class="btn btn-primary rounded cursor-pointer">Save</button>
            </div>
        </div>
    </div>

    <!-- Edit Chapter Modal -->
    <div id="editChapterModal" class="hidden fixed inset-0 z-50 items-center justify-center">
        <div id="editChapterOverlay" class="absolute inset-0 bg-black opacity-60"></div>
        <div class="relative bg-[#141414] rounded-lg w-full max-w-md p-6 z-50 border border-gray-700">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-xl font-bold">Edit Chapter</h2>
                    <p class="text-sm text-gray-400 mt-1">Change the chapter title below.</p>
                </div>
                <button id="editChapterClose" class="text-gray-300 hover:text-white ml-4 cursor-pointer">✕</button>
            </div>

            <div class="mt-4">
                <input id="editChapterNameInput" type="text" placeholder="Chapter name" class="w-full px-3 py-2 rounded bg-[#1e1e1e] border border-gray-600 text-white" />
            </div>

            <div class="mt-6 flex justify-end">
                <button id="saveEditChapterBtn" class="btn btn-primary rounded cursor-pointer">Save</button>
            </div>
        </div>
    </div>
    </section>
     

    <!-- Lesson Create/Edit Modal -->
    <div id="lessonModal" class="hidden fixed inset-0 z-50 items-center justify-center">
        <div id="lessonModalOverlay" class="absolute inset-0 bg-black opacity-60"></div>
        <div class="relative bg-[#141414] rounded-lg w-full max-w-lg p-6 z-50 border border-gray-700">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-xl font-bold" id="lessonModalTitle">Create Lesson</h2>
                </div>
                <button id="lessonModalClose" class="text-gray-300 hover:text-white ml-4 cursor-pointer">✕</button>
            </div>

            <div class="mt-4 space-y-3">
                <input id="lessonTitleInput" type="text" placeholder="Lesson title" class="w-full px-3 py-2 rounded bg-[#1e1e1e] border border-gray-600 text-white" />
                <textarea id="lessonDescInput" placeholder="Description (optional)" class="w-full px-3 py-2 rounded bg-[#1e1e1e] border border-gray-600 text-white" rows="4"></textarea>
            </div>

            <div class="mt-6 flex justify-end">
                <button id="saveLessonBtn" class="btn btn-primary rounded cursor-pointer">Save</button>
            </div>
        </div>
    </div>
    <!-- New Chapter Modal -->
    <div id="newChapterModal" class="hidden fixed inset-0 z-50 items-center justify-center">
        <div id="modalOverlay" class="absolute inset-0 bg-black opacity-60"></div>
        <div class="relative bg-[#141414] rounded-lg w-full max-w-md p-6 z-50 border border-gray-700">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-xl font-bold">Create New Chapter</h2>
                    <p class="text-sm text-gray-400 mt-1">What would you like to name your chapter?</p>
                </div>
                <!-- Cancel (top-right) -->
                <button id="modalClose" class="text-gray-300 hover:text-white ml-4 cursor-pointer">✕</button>
            </div>

            <div class="mt-4">
                <input id="chapterNameInput" type="text" placeholder="Chapter name" class="w-full px-3 py-2 rounded bg-[#1e1e1e] border border-gray-600 text-white" />
            </div>

            <div class="mt-6 flex justify-end">
                <button id="saveChapterBtn" class="btn btn-primary rounded cursor-pointer">Save</button>
            </div>
        </div>
    </div>

    <script>
// Modal handling for creating a new chapter
const btnNewChapter = document.getElementById('btnNewChapter');
const newChapterModal = document.getElementById('newChapterModal');
const modalClose = document.getElementById('modalClose');
const modalOverlay = document.getElementById('modalOverlay');
const chapterNameInput = document.getElementById('chapterNameInput');
const saveChapterBtn = document.getElementById('saveChapterBtn');
// Lesson modal elements
const lessonModal = document.getElementById('lessonModal');
const lessonModalOverlay = document.getElementById('lessonModalOverlay');
const lessonModalClose = document.getElementById('lessonModalClose');
const lessonTitleInput = document.getElementById('lessonTitleInput');
const lessonDescInput = document.getElementById('lessonDescInput');
const saveLessonBtn = document.getElementById('saveLessonBtn');

let currentLessonChapterId = null;
let currentEditingLessonId = null;
// Current course id and title elements
const CURRENT_COURSE_ID = <?= json_encode($course['id']) ?>;
const courseTitleEl = document.getElementById('courseTitle');
const editCourseBtn = document.getElementById('editCourseBtn');

function openModal(){
    newChapterModal.classList.remove('hidden');
    newChapterModal.classList.add('flex');
    setTimeout(()=> chapterNameInput.focus(), 50);
}
function closeModal(){
    newChapterModal.classList.add('hidden');
    newChapterModal.classList.remove('flex');
    chapterNameInput.value = '';
}

btnNewChapter && btnNewChapter.addEventListener('click', openModal);
modalClose && modalClose.addEventListener('click', closeModal);
modalOverlay && modalOverlay.addEventListener('click', closeModal);
document.addEventListener('keydown', (e)=>{ if(e.key === 'Escape') closeModal(); });

function escapeHtml(unsafe) {
    return unsafe
         .replace(/&/g, "&amp;")
         .replace(/</g, "&lt;")
         .replace(/>/g, "&gt;")
         .replace(/\"/g, "&quot;")
         .replace(/'/g, "&#039;");
}

saveChapterBtn && saveChapterBtn.addEventListener('click', function(){
    const name = chapterNameInput.value.trim();
    if(!name){ chapterNameInput.focus(); return; }

    // POST to server to create chapter in DB
    fetch('course_api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'create_chapter', course_id: CURRENT_COURSE_ID, title: name })
    })
    .then(r => r.json())
    .then(data => {
        if(!data.success){
            alert(data.error || 'Failed to create chapter');
            return;
        }

        const id = data.chapter_id;
        const container = document.getElementById('chapters');
        const card = document.createElement('div');
        card.className = 'bg-transparent border  shadow-lg shadow-[rgba(0,0,0,0.2)] rounded-lg p-5';
        card.setAttribute('data-id', id);

        card.innerHTML = `
            <div class="flex  justify-between items-center my-2">
                <h3 class=" text-l font-semibold flex items-center gap-2 cursor-move">☰ ${escapeHtml(data.chapter_title)}</h3>
                <div class="space-x-2 flex flex-row justify-center ">
                    <button class="edit-chapter-btn cursor-pointer border rounded bg-[#636FF2] border-white" data-chapter-id="${id}">Edit</button>
                    <button class="delete-chapter-btn cursor-pointer bg-[#ff0000] border-white border rounded" data-chapter-id="${id}">Delete</button>
                </div>
            </div>
            <hr class="my-3 border-gray-300">
            <ul class="lesson-list space-y-4" id="chapter-${id}"></ul>
            <button class="mt-4 w-full bg-[#2e2e2e] py-2 rounded cursor-pointer border border-gray-300  hover:bg-[#3e3e3e] create-lesson-btn" data-chapter-id="${id}">Create New Lesson</button>
        `;

        container.appendChild(card);

        // Initialize Sortable for the new chapter's lessons list (persist order)
        const newList = card.querySelector('.lesson-list');
        if(newList){
            new Sortable(newList, {
                animation: 150,
                handle: ".cursor-move",
                onEnd: function (evt) {
                    const chapterId = (newList.id || '').replace('chapter-','');
                    const order = Array.from(newList.querySelectorAll('[data-id]')).map(el => el.getAttribute('data-id'));
                    fetch('course_api.php', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ action:'update_lesson_order', chapter_id: parseInt(chapterId,10), order }) });
                }
            });
        }

        closeModal();
    })
    .catch(err => {
        console.error(err);
        alert('Network error while creating chapter');
    });
});

/* ---------------------------------------------------
   DRAGGABLE CHAPTERS
--------------------------------------------------- */
new Sortable(document.getElementById('chapters'), {
    animation: 150,
    handle: ".cursor-move",
    onEnd: function (evt) {
        // persist chapter order
        const container = document.getElementById('chapters');
        const order = Array.from(container.querySelectorAll(':scope > div[data-id]')).map(d=>d.getAttribute('data-id'));
        fetch('course_api.php', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ action:'update_chapter_order', order }) });
    }
});

/* ---------------------------------------------------
   DRAGGABLE LESSONS for EACH CHAPTER
--------------------------------------------------- */
document.querySelectorAll(".lesson-list").forEach(list => {
    new Sortable(list, {
        animation: 150,
        handle: ".cursor-move",
        onEnd: function (evt) {
            const chapterId = (list.id || '').replace('chapter-','');
            const order = Array.from(list.querySelectorAll('[data-id]')).map(el => el.getAttribute('data-id'));
            fetch('course_api.php', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ action:'update_lesson_order', chapter_id: parseInt(chapterId,10), order }) });
        }
    });
});

// --- Edit course name modal handling ---
const editCourseModal = document.getElementById('editCourseModal');
const editModalCloseBtn = document.getElementById('editModalClose');
const editModalOverlay = document.getElementById('editModalOverlay');
const courseNameInput = document.getElementById('courseNameInput');
const saveCourseBtnEl = document.getElementById('saveCourseBtn');

if(editCourseBtn) editCourseBtn.addEventListener('click', ()=>{
    if(editCourseModal){
        editCourseModal.classList.remove('hidden');
        editCourseModal.classList.add('flex');
        setTimeout(()=> courseNameInput.focus(), 50);
    }
});
if(editModalCloseBtn) editModalCloseBtn.addEventListener('click', ()=>{ editCourseModal.classList.add('hidden'); editCourseModal.classList.remove('flex'); });
if(editModalOverlay) editModalOverlay.addEventListener('click', ()=>{ editCourseModal.classList.add('hidden'); editCourseModal.classList.remove('flex'); });

saveCourseBtnEl && saveCourseBtnEl.addEventListener('click', ()=>{
    const newTitle = courseNameInput.value.trim();
    if(!newTitle){ courseNameInput.focus(); return; }

    fetch('course_api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'update_course_title', course_id: CURRENT_COURSE_ID, title: newTitle })
    })
    .then(r => r.json())
    .then(data => {
        if(!data.success){ alert(data.error || 'Failed to update course'); return; }
        if(courseTitleEl) courseTitleEl.textContent = data.course_title;
        editCourseModal.classList.add('hidden');
        editCourseModal.classList.remove('flex');
    })
    .catch(err => { console.error(err); alert('Network error updating course'); });
});

// --- Edit / Delete chapter handlers ---
let currentEditChapterId = null;
const editChapterModal = document.getElementById('editChapterModal');
const editChapterClose = document.getElementById('editChapterClose');
const editChapterOverlay = document.getElementById('editChapterOverlay');
const editChapterNameInput = document.getElementById('editChapterNameInput');
const saveEditChapterBtn = document.getElementById('saveEditChapterBtn');

// Delegate clicks for chapter and lesson actions
document.getElementById('chapters').addEventListener('click', function(e){
    const editChapterBtnEl = e.target.closest('.edit-chapter-btn');
    const delChapterBtnEl = e.target.closest('.delete-chapter-btn');
    const createLessonBtn = e.target.closest('.create-lesson-btn');
    const editLessonBtn = e.target.closest('.edit-lesson-btn');
    const deleteLessonBtn = e.target.closest('.delete-lesson-btn');

    // Chapter edit
    if(editChapterBtnEl){
        const cid = editChapterBtnEl.getAttribute('data-chapter-id');
        currentEditChapterId = cid;
        editChapterNameInput.value = editChapterBtnEl.closest('div').previousElementSibling ? editChapterBtnEl.closest('div').previousElementSibling.textContent.replace('☰','').trim() : '';
        editChapterModal.classList.remove('hidden'); editChapterModal.classList.add('flex');
        setTimeout(()=> editChapterNameInput.focus(), 50);
        return;
    }

    // Chapter delete
    if(delChapterBtnEl){
        const cid = delChapterBtnEl.getAttribute('data-chapter-id');
        if(!confirm('Delete this chapter? This will also delete its lessons.')) return;
        fetch('course_api.php', {
            method: 'POST', headers: {'Content-Type':'application/json'},
            body: JSON.stringify({ action: 'delete_chapter', chapter_id: parseInt(cid,10) })
        })
        .then(r=>r.json())
        .then(data=>{
            if(!data.success){ alert(data.error||'Delete failed'); return; }
            const card = delChapterBtnEl.closest('[data-id]');
            if(card) card.remove();
        }).catch(err=>{ console.error(err); alert('Network error while deleting chapter'); });
        return;
    }

    // Create lesson
    if(createLessonBtn){
        currentLessonChapterId = createLessonBtn.getAttribute('data-chapter-id');
        currentEditingLessonId = null;
        document.getElementById('lessonModalTitle').textContent = 'Create Lesson';
        lessonTitleInput.value = '';
        lessonDescInput.value = '';
        lessonModal.classList.remove('hidden'); lessonModal.classList.add('flex');
        setTimeout(()=> lessonTitleInput.focus(), 50);
        return;
    }

    // Edit lesson
    if(editLessonBtn){
        const lid = editLessonBtn.getAttribute('data-lesson-id');
        currentEditingLessonId = lid;
        // find title and description from DOM (title only available)
        const li = editLessonBtn.closest('[data-id]');
        const titleSpan = li ? li.querySelector('span') : null;
        const titleText = titleSpan ? titleSpan.textContent.replace('☰','').trim() : '';
        document.getElementById('lessonModalTitle').textContent = 'Edit Lesson';
        lessonTitleInput.value = titleText;
        // description not present on the list; leave blank or fetch later
        lessonDescInput.value = '';
        // set chapter id context
        const chapterUl = editLessonBtn.closest('.lesson-list');
        currentLessonChapterId = chapterUl ? (chapterUl.id || '').replace('chapter-','') : null;
        lessonModal.classList.remove('hidden'); lessonModal.classList.add('flex');
        setTimeout(()=> lessonTitleInput.focus(), 50);
        return;
    }

    // Delete lesson
    if(deleteLessonBtn){
        const lid = deleteLessonBtn.getAttribute('data-lesson-id');
        if(!confirm('Delete this lesson?')) return;
        fetch('course_api.php', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ action:'delete_lesson', lesson_id: parseInt(lid,10) }) })
        .then(r=>r.json())
        .then(data=>{
            if(!data.success){ alert(data.error||'Delete failed'); return; }
            const li = deleteLessonBtn.closest('[data-id]');
            if(li) li.remove();
        }).catch(err=>{ console.error(err); alert('Network error deleting lesson'); });
        return;
    }
});

if(editChapterClose) editChapterClose.addEventListener('click', ()=>{ editChapterModal.classList.add('hidden'); editChapterModal.classList.remove('flex'); });
if(editChapterOverlay) editChapterOverlay.addEventListener('click', ()=>{ editChapterModal.classList.add('hidden'); editChapterModal.classList.remove('flex'); });

saveEditChapterBtn && saveEditChapterBtn.addEventListener('click', ()=>{
    const newTitle = editChapterNameInput.value.trim();
    if(!newTitle){ editChapterNameInput.focus(); return; }
    fetch('course_api.php', { method: 'POST', headers: {'Content-Type':'application/json'}, body: JSON.stringify({ action: 'update_chapter', chapter_id: parseInt(currentEditChapterId,10), title: newTitle }) })
    .then(r=>r.json())
    .then(data=>{
        if(!data.success){ alert(data.error||'Update failed'); return; }
        // update DOM title
        const card = document.querySelector('[data-id="'+data.chapter_id+'"]');
        if(card){
            const h3 = card.querySelector('h3');
            if(h3) h3.textContent = '☰ ' + data.chapter_title;
        }
        editChapterModal.classList.add('hidden'); editChapterModal.classList.remove('flex');
    }).catch(err=>{ console.error(err); alert('Network error while updating chapter'); });
});

// Lesson modal controls
if(lessonModalClose) lessonModalClose.addEventListener('click', ()=>{ lessonModal.classList.add('hidden'); lessonModal.classList.remove('flex'); });
if(lessonModalOverlay) lessonModalOverlay.addEventListener('click', ()=>{ lessonModal.classList.add('hidden'); lessonModal.classList.remove('flex'); });

saveLessonBtn && saveLessonBtn.addEventListener('click', ()=>{
    const title = lessonTitleInput.value.trim();
    const desc = lessonDescInput.value.trim();
    if(!title){ lessonTitleInput.focus(); return; }

    if(currentEditingLessonId){
        // update
        fetch('course_api.php', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ action:'update_lesson', lesson_id: parseInt(currentEditingLessonId,10), title, description: desc }) })
        .then(r=>r.json())
        .then(data=>{
            if(!data.success){ alert(data.error||'Update failed'); return; }
            const li = document.querySelector('[data-id="'+data.lesson_id+'"]');
            if(li){
                const span = li.querySelector('span');
                if(span) span.textContent = '☰ ' + data.title;
            }
            lessonModal.classList.add('hidden'); lessonModal.classList.remove('flex');
        }).catch(err=>{ console.error(err); alert('Network error updating lesson'); });
    } else {
        // create
        fetch('course_api.php', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ action:'create_lesson', chapter_id: parseInt(currentLessonChapterId,10), title, description: desc }) })
        .then(r=>r.json())
        .then(data=>{
            if(!data.success){ alert(data.error||'Create failed'); return; }
            // append to the chapter list
            const ul = document.getElementById('chapter-'+currentLessonChapterId);
            if(ul){
                const li = document.createElement('li');
                li.className = 'bg-[#2e2e2e] shadow-lg shadow-[rgba(0,0,0,0.2)] hover:bg-[#3e3e3e] p-3 rounded flex justify-between items-center cursor-move';
                li.setAttribute('data-id', data.lesson_id);
                li.innerHTML = `<span>☰ ${escapeHtml(data.title)}</span><div class="flex flex-row justify-center space-x-2 "><button class="edit-lesson-btn cursor-pointer border rounded bg-[#636FF2] border-white" data-lesson-id="${data.lesson_id}">Edit</button><button class="delete-lesson-btn bg-[#ff0000] border-white border rounded cursor-pointer" data-lesson-id="${data.lesson_id}">Delete</button></div>`;
                ul.appendChild(li);
            }
            lessonModal.classList.add('hidden'); lessonModal.classList.remove('flex');
        }).catch(err=>{ console.error(err); alert('Network error creating lesson'); });
    }
});
</script>
</body>
</html>