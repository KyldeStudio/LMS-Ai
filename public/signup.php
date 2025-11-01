<?php
include '../include/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Basic validation
    if (empty($fullname) || empty($age) || empty($email) || empty($username) || empty($password)) {
        $error = "All fields are required!";
    } else {
        // Hash password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (fullname, age, email, username, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sisss", $fullname, $age, $email, $username, $hashed_password);

        if ($stmt->execute()) {
            $success = "Account created successfully!";
        } else {
            $error = "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" href="../dist/style.css">
    <link rel="stylesheet" href="../dist/gen.css">
    
</head>
<body class="text-white ">

    <div class="flex justify-center items-center h-screen">
        <div class="bg-[#1F2328] py-12 rounded-xl px-16">

            <div class="text-center">
                <a href="index.php">
                    <img src="../assets/logo.png" alt="logo" class="mx-auto h-12 mb-4 mt-4">
                </a>
                
                <p class="text-lg font-bold mb-2">Create your account</p>
                <p class="text-sm px-20">Fill in the details below to create your account</p>
            </div>

            <?php if (!empty($error)): ?>
                <p class="text-red-500 text-center mb-2"><?= $error ?></p>
            <?php elseif (!empty($success)): ?>
                <p class="text-green-500 text-center mb-2"><?= $success ?></p>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="flex flex-col space-y-2 my-4">  

                    <div class="flex flex-col">
                        <label>Full Name</label>
                        <input type="text" name="fullname" class="border border-[#9c9c9c] rounded py-2 px-2" placeholder="Enter your full name">
                    </div>

                    <div class="flex flex-col">
                        <label>Age</label>
                        <input type="number" name="age" class="border border-[#9c9c9c] rounded py-2 px-2" placeholder="Enter your age">
                    </div>

                    <div class="flex flex-col">
                        <label>Email</label>
                        <input type="email" name="email" class="border border-[#9c9c9c] rounded py-2 px-2" placeholder="Enter your email">
                    </div>
                
                    <div class="flex flex-col">
                        <label>Username</label>
                        <input type="text" name="username" class="border border-[#9c9c9c] rounded py-2 px-2" placeholder="Choose a username">
                    </div>

                    <div class="flex flex-col">
                        <label>Password</label>
                        <input type="password" name="password" class="border border-[#9c9c9c] rounded py-2 px-2" placeholder="Create a password">
                    </div>
                    
                    <input type="submit" class="bg-[#238636] font-bold cursor-pointer rounded py-2 mt-2" value="Create Account">

                    <p class="text-center">Already have an account? 
                        <strong><a href="login.php" class="underline">Login</a></strong>
                    </p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

