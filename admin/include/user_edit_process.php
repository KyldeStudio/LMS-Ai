<?php
include '../include/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $age = intval($_POST['age']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $query = "UPDATE users SET fullname='$fullname', email='$email', age=$age, username='$username', password='$password' WHERE id=$id";
    } else {
        $query = "UPDATE users SET fullname='$fullname', email='$email', age=$age, username='$username' WHERE id=$id";
    }

    if (mysqli_query($conn, $query)) {
        header("Location: manage_user.php?id=$id&updated=1");
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>
