<?php
include '../../include/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $age = intval($_POST['age']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO users (fullname, email, age, username, password, created_at)
              VALUES ('$fullname', '$email', $age, '$username', '$password', NOW())";

    if (mysqli_query($conn, $query)) {
        header("Location: ../manage_user.php?success=1");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
