<?php
include '../../include/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = mysqli_real_escape_string($conn, $_POST['fullname']); // use 'fullname' from your form but store in 'firstname'
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $office_hours = mysqli_real_escape_string($conn, $_POST['office_hours']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO instructors (fullname, email, office_hours, username, password, created_at)
              VALUES ('$firstname', '$email', '$office_hours', '$username', '$password', NOW())";

    if (mysqli_query($conn, $query)) {
        header("Location: ../manage_instructors.php?success=1");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
