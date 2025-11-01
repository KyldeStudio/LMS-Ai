<?php
session_start();
include '../include/db_connect.php';

// Detect if "Add" mode is triggered
$isAddMode = isset($_GET['add']);


// Fetch all users
$query = "SELECT id, CONCAT(fullname) AS fullname FROM users ORDER BY fullname ASC";
$result = mysqli_query($conn, $query);

// If a user is clicked
$selectedUser = null;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $infoQuery = "SELECT * FROM users WHERE id = $id";
    $infoResult = mysqli_query($conn, $infoQuery);
    $selectedUser = mysqli_fetch_assoc($infoResult);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="../dist/style.css">
    <link rel="stylesheet" href="../public/gen.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-[#121212] text-white">
    <!-- Sidebar -->
    

    <!-- Main Section -->
    <main class="relative h-screen w-auto flex flex-col ml-[400px] items-start justify-start  p-8 space-y-4">

        <div class="flex flex-col space-y-4">
            <h2 class="font-bold text-xl">User Management</h2>
            <div class="rounded-md border border-gray-300 overflow-hidden">
                <Button class="py-2 px-6 text-black bg-white"><a href="">User</a></Button>
                <Button class="bg-transparent py-2 px-6"><a href="manage_instructors.php">Instructors</a></Button>
            </div>
        </div>


        <div class="flex flex-row w-full">
            <!-- Sidebar user list -->
            <div class=" min-w-[400px] max-w-[400px] bg-[#181818] border rounded-l-md border-gray-400 p-4 space-y-4">
                <div class="flex justify-between items-center space-x-4">
                    <input type="text" class="border py-2 px-4 rounded-md w-full" placeholder="Search">
                    <a href="?add=true" 
                        class="bg-[#006fff] p-2 rounded-full hover:bg-blue-700 transition-all duration-300 cursor-pointer flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 512 512">
                                <path d="M492 236H276V20c0-11.046-8.954-20-20-20s-20 8.954-20 20v216H20c-11.046 0-20 8.954-20 20s8.954 20 20 20h216v216
                                        c0 11.046 8.954 20 20 20s20-8.954 20-20V276h216
                                        c11.046 0 20-8.954 20-20s-8.954-20-20-20z"
                                    fill="#ffffff"></path>
                            </svg>
                    </a>

                </div>

                <!-- Dynamic user list -->
                <div class="space-y-2">
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <a href="?id=<?= $row['id'] ?>" class="flex items-center p-3 rounded-md bg-[#222] hover:bg-[#333] transition-all">
                            <div class="ml-2 text-sm font-semibold"><?= htmlspecialchars($row['fullname']) ?></div>
                        </a>
                    <?php endwhile; ?>
                </div>
            </div>

        <!-- User Information Panel -->
        <div class="fixed left-[832px] bg-[#181818] border rounded-r-md border-gray-400 h-full py-4 px-8 space-y-4 w-[400px]">
            <div class="flex flex-row items-center justify-between">
                <h3 class="text-xl font-bold">
                    <?= $isAddMode ? 'Add New User' : 'User Information' ?>
                </h3>
                <div class="flex flex-row space-x-4 items-center justify-center">
                    <?php if ($isAddMode): ?>
                        <a href="manage_user.php" class="text-gray-400 hover:underline">Cancel</a>
                    <?php else: ?>
                        <button class="text-blue-400 hover:underline">Edit</button>
                        <button class="text-red-400 hover:underline">Delete</button>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($isAddMode): ?>
                <!-- ADD USER FORM -->
                <form action="user_add_process.php" method="POST" class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1">Full Name</label>
                        <input type="text" name="fullname" class="w-full p-2 rounded bg-[#222] border border-gray-600" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Email</label>
                        <input type="email" name="email" class="w-full p-2 rounded bg-[#222] border border-gray-600" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Age</label>
                        <input type="number" name="age" class="w-full p-2 rounded bg-[#222] border border-gray-600" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Username</label>
                        <input type="text" name="username" class="w-full p-2 rounded bg-[#222] border border-gray-600" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Password</label>
                        <input type="password" name="password" class="w-full p-2 rounded bg-[#222] border border-gray-600" required>
                    </div>
                    <button type="submit" class="w-full text-center cursor-pointer bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md font-semibold">
                        Add User
                    </button>
                </form>

            <?php elseif ($selectedUser): ?>
                <!-- EXISTING USER INFO -->
                <div class="space-y-4">
                    <p><span class="font-semibold">ID:</span> <?= htmlspecialchars($selectedUser['id']) ?></p>
                    <p><span class="font-semibold">Full Name:</span> <?= htmlspecialchars($selectedUser['fullname']) ?></p>
                    <p><span class="font-semibold">Email:</span> <?= htmlspecialchars($selectedUser['email']) ?></p>
                    <p><span class="font-semibold">Age:</span> <?= htmlspecialchars($selectedUser['age']) ?></p>
                    <p><span class="font-semibold">Username:</span> <?= htmlspecialchars($selectedUser['username']) ?></p>
                    <p><span class="font-semibold">Created at:</span> <?= htmlspecialchars($selectedUser['created_at']) ?></p>
                </div>
            <?php else: ?>
                <p class="text-gray-400">Select a user to view information.</p>
            <?php endif; ?>
        </div>

        </div>
    </main>
</body>
</html>
