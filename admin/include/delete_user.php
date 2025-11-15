<?php
ob_start(); // Ensures no output before redirect
include '../include/db_connect.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $query = "DELETE FROM users WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        // Redirect back with success message
        header("Location: manage_user.php?deleted=1");
        exit();
    } else {
        // Redirect back with error
        header("Location: manage_user.php?error=1");
        exit();
    }
} else {
    header("Location: manage_user.php");
    exit();
}

ob_end_flush();
?>
