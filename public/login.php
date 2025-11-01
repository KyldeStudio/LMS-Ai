<?php
session_start();
include '../include/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                // ✅ Login success
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                header("Location: loged.php"); // redirect to dashboard or homepage
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "Username not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../dist/style.css">
    <link rel="stylesheet" href="gen.css">


</head>
<body class="text-white font-poppins">
    
    <div class="flex justify-center items-center h-screen">
        <div class="bg-[#1F2328] py-12 rounded-xl px-16">
            <!-- Logo top -->
            <div class="text-center">
                <a href="index.php">
                    <img src="../assets/logo.png" alt="logo" class="mx-auto h-12 mb-4 mt-4">
                </a>
                <p class="text-lg font-bold mb-2">Login to your account</p>
                <p class="text-sm px-12">Enter your username and password below to login</p>
            </div>

            <!-- Error message -->
            <?php if (!empty($error)): ?>
                <p class="text-red-500 text-center mb-2"><?= $error ?></p>
            <?php endif; ?>

            <!-- Login Form -->
            <form method="POST" action="">
                <div class="flex flex-col space-y-2 my-4">

                    <div class="flex flex-col">
                        <label>Username</label>
                        <input type="text" name="username" class="border border-[#9c9c9c] rounded py-2 px-2" placeholder="Enter your username">
                    </div>
                    
                    <div class="flex flex-col">
                        <div class="flex justify-between">
                            <label>Password</label>
                            <a href="#" class="text-blue-500 text-sm">Forgot Password?</a>
                        </div>

                        <input type="password" name="password" class="border border-[#9c9c9c] rounded py-2 px-2" placeholder="Enter your password">
                    </div>
                    
                    <input type="submit" class="bg-[#238636] font-bold cursor-pointer rounded py-2 mt-2" value="Login">

                </div>
            </form>

            <!-- Signup link -->
            <div class="text-center">
                <p>Don't have an account?
                    <strong><a href="signup.php" class="underline">Sign up</a></strong>
                </p>
            </div>
        </div>
    </div>

</body>
</html>
