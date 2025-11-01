<?php
include '../include/db_connect.php';

$id = $_POST['id'];
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$age = $_POST['age'];
$username = $_POST['username'];
$password = $_POST['password'];

if (!empty($password)) {
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $query = "UPDATE instructors SET fullname='$fullname', email='$email', office_hours='$office_hours', username='$username', password='$passwordHash' WHERE id=$id";
} else {
    $query = "UPDATE instructors SET fullname='$fullname', email='$email', office_hours='$office_hours', username='$username' WHERE id=$id";
}

if (mysqli_query($conn, $query)) {
    header("Location: manage_instructors.php?id=$id");
    exit();
} else {
    echo "Error updating record: " . mysqli_error($conn);
}
?>
