<?php
session_start();
include '../include/db_connect.php';

// Detect if "Add" mode is triggered
$isAddMode = isset($_GET['add']);


// Fetch all users
$query = "SELECT id, CONCAT(fullname) AS fullname FROM instructors ORDER BY fullname ASC";
$result = mysqli_query($conn, $query);

$isEditMode = isset($_GET['edit']) && isset($_GET['id']);

$search = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $query = "SELECT id, fullname FROM instructors WHERE fullname LIKE '%$search%' ORDER BY fullname ASC";
} else {
    $query = "SELECT id, fullname FROM instructors ORDER BY fullname ASC";
}
$result = mysqli_query($conn, $query);

// If a user is clicked
$selectedInstructors = null;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $infoQuery = "SELECT * FROM instructors WHERE id = $id";
    $infoResult = mysqli_query($conn, $infoQuery);
    $selectedInstructors = mysqli_fetch_assoc($infoResult);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Instructors</title>
    <link rel="stylesheet" href="../dist/style.css">
    <link rel="stylesheet" href="../public/gen.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-[#121212] text-white">
    <!-- Sidebar -->
    <section class="w-[350px] bg-[#181818] h-screen fixed top-0 left-0 flex flex-col">
        <div class="mx-8 mt-4 space-y-2 ">
            <!-- header -->
            <h3 class="font-bold">Administrator</h3>

            <!-- Link -->
            <a href="manage_course.php" class="border-b border-gray-300 flex flex-row justify-between items-center shadow-lg py-2 px-2  hover:bg-gray-600 hover:rounded-lg transition-all duration-300">
                <div class="flex flex-row space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M466.6 199.1c-8.3-11.3-21.1-17.8-35.1-17.8h-10.6v-28.5c0-24-19.5-43.5-43.6-43.5H250.1c-7.3 0-14.3-2.9-19.5-8l-20-19.9c-8.2-8.2-19.1-12.7-30.7-12.7H80.5c-24 0-43.5 19.5-43.5 43.6V366c-.3 9.7 2.6 19.3 8.5 27.3 8.4 11.4 21.3 18 35.5 18h305.9c19.1 0 35.8-12.3 41.6-30.6l44.7-142.9c4.1-13.3 1.7-27.4-6.6-38.7zM52.9 112.3c0-15.2 12.4-27.6 27.5-27.6h99.5c7.3 0 14.2 2.9 19.5 8l20 19.9c8.2 8.2 19.1 12.7 30.7 12.7h127.3c15.2 0 27.6 12.4 27.6 27.5v28.5H125c-19.1 0-35.8 12.3-41.6 30.5l-30.6 97.6V112.3zm404.9 120.8L413.1 376c-3.6 11.6-14.2 19.3-26.3 19.3H80.9c-9 0-17.2-4.2-22.6-11.4-5.3-7.3-6.9-16.4-4.2-25l44.5-142.3c3.6-11.6 14.2-19.3 26.3-19.3h306.5c8.9 0 17 4.1 22.2 11.2 5.4 7.2 6.9 16.1 4.2 24.6z" fill="#ffffff" opacity="1" data-original="#000000" class=""></path></g></svg>
                    <!-- Description -->
                    <span class="text-[15px]">Course Management</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" x="0" y="0" viewBox="0 0 492.004 492.004" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M382.678 226.804 163.73 7.86C158.666 2.792 151.906 0 144.698 0s-13.968 2.792-19.032 7.86l-16.124 16.12c-10.492 10.504-10.492 27.576 0 38.064L293.398 245.9l-184.06 184.06c-5.064 5.068-7.86 11.824-7.86 19.028 0 7.212 2.796 13.968 7.86 19.04l16.124 16.116c5.068 5.068 11.824 7.86 19.032 7.86s13.968-2.792 19.032-7.86L382.678 265c5.076-5.084 7.864-11.872 7.848-19.088.016-7.244-2.772-14.028-7.848-19.108z" fill="#ffffff" opacity="1" data-original="#000000"></path></g></svg>
            </a>

            <a href="manage_user.php" class="border-b border-gray-300 flex flex-row justify-between items-center shadow-lg py-2 px-2 rounded-lg bg-gray-600  hover:rounded-lg transition-all duration-300">
                        <div class="flex flex-row space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M466.6 199.1c-8.3-11.3-21.1-17.8-35.1-17.8h-10.6v-28.5c0-24-19.5-43.5-43.6-43.5H250.1c-7.3 0-14.3-2.9-19.5-8l-20-19.9c-8.2-8.2-19.1-12.7-30.7-12.7H80.5c-24 0-43.5 19.5-43.5 43.6V366c-.3 9.7 2.6 19.3 8.5 27.3 8.4 11.4 21.3 18 35.5 18h305.9c19.1 0 35.8-12.3 41.6-30.6l44.7-142.9c4.1-13.3 1.7-27.4-6.6-38.7zM52.9 112.3c0-15.2 12.4-27.6 27.5-27.6h99.5c7.3 0 14.2 2.9 19.5 8l20 19.9c8.2 8.2 19.1 12.7 30.7 12.7h127.3c15.2 0 27.6 12.4 27.6 27.5v28.5H125c-19.1 0-35.8 12.3-41.6 30.5l-30.6 97.6V112.3zm404.9 120.8L413.1 376c-3.6 11.6-14.2 19.3-26.3 19.3H80.9c-9 0-17.2-4.2-22.6-11.4-5.3-7.3-6.9-16.4-4.2-25l44.5-142.3c3.6-11.6 14.2-19.3 26.3-19.3h306.5c8.9 0 17 4.1 22.2 11.2 5.4 7.2 6.9 16.1 4.2 24.6z" fill="#ffffff" opacity="1" data-original="#000000" class=""></path></g></svg>
                            <!-- Description -->
                            <span class="text-[15px]">User Management</span>
                        </div>
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" x="0" y="0" viewBox="0 0 492.004 492.004" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M382.678 226.804 163.73 7.86C158.666 2.792 151.906 0 144.698 0s-13.968 2.792-19.032 7.86l-16.124 16.12c-10.492 10.504-10.492 27.576 0 38.064L293.398 245.9l-184.06 184.06c-5.064 5.068-7.86 11.824-7.86 19.028 0 7.212 2.796 13.968 7.86 19.04l16.124 16.116c5.068 5.068 11.824 7.86 19.032 7.86s13.968-2.792 19.032-7.86L382.678 265c5.076-5.084 7.864-11.872 7.848-19.088.016-7.244-2.772-14.028-7.848-19.108z" fill="#ffffff" opacity="1" data-original="#000000"></path></g></svg>
            </a>

                <a href="#" class="border-b border-gray-300 flex flex-row justify-between items-center shadow-lg py-2 px-2  hover:bg-gray-600  hover:rounded-lg transition-all duration-300">
                        <div class="flex flex-row space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M466.6 199.1c-8.3-11.3-21.1-17.8-35.1-17.8h-10.6v-28.5c0-24-19.5-43.5-43.6-43.5H250.1c-7.3 0-14.3-2.9-19.5-8l-20-19.9c-8.2-8.2-19.1-12.7-30.7-12.7H80.5c-24 0-43.5 19.5-43.5 43.6V366c-.3 9.7 2.6 19.3 8.5 27.3 8.4 11.4 21.3 18 35.5 18h305.9c19.1 0 35.8-12.3 41.6-30.6l44.7-142.9c4.1-13.3 1.7-27.4-6.6-38.7zM52.9 112.3c0-15.2 12.4-27.6 27.5-27.6h99.5c7.3 0 14.2 2.9 19.5 8l20 19.9c8.2 8.2 19.1 12.7 30.7 12.7h127.3c15.2 0 27.6 12.4 27.6 27.5v28.5H125c-19.1 0-35.8 12.3-41.6 30.5l-30.6 97.6V112.3zm404.9 120.8L413.1 376c-3.6 11.6-14.2 19.3-26.3 19.3H80.9c-9 0-17.2-4.2-22.6-11.4-5.3-7.3-6.9-16.4-4.2-25l44.5-142.3c3.6-11.6 14.2-19.3 26.3-19.3h306.5c8.9 0 17 4.1 22.2 11.2 5.4 7.2 6.9 16.1 4.2 24.6z" fill="#ffffff" opacity="1" data-original="#000000" class=""></path></g></svg>
                            <!-- Description -->
                            <span class="text-[15px]">Certificate Management</span>
                        </div>
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" x="0" y="0" viewBox="0 0 492.004 492.004" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M382.678 226.804 163.73 7.86C158.666 2.792 151.906 0 144.698 0s-13.968 2.792-19.032 7.86l-16.124 16.12c-10.492 10.504-10.492 27.576 0 38.064L293.398 245.9l-184.06 184.06c-5.064 5.068-7.86 11.824-7.86 19.028 0 7.212 2.796 13.968 7.86 19.04l16.124 16.116c5.068 5.068 11.824 7.86 19.032 7.86s13.968-2.792 19.032-7.86L382.678 265c5.076-5.084 7.864-11.872 7.848-19.088.016-7.244-2.772-14.028-7.848-19.108z" fill="#ffffff" opacity="1" data-original="#000000"></path></g></svg>
            </a>
        </div>
    </section>

    <!-- Main Section -->
    <main class="relative h-screen w-auto flex flex-col ml-[400px] items-start justify-start  p-8 space-y-4">

        <div class="flex flex-col space-y-4">
            <h2 class="font-bold text-xl">Instructor Management</h2>
            <?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
                <div class="bg-red-500 text-white p-2 rounded-md">
                    Instructor deleted successfully.
                </div>
            <?php endif; ?>

            <div class="rounded-md border border-gray-300 overflow-hidden w-fit">
                <Button class="bg-transparent py-2 px-6"><a href="manage_user.php">User</a></Button>
                <Button class="py-2 px-6 text-black bg-white"><a href="manage_instructors.php">Instructors</a></Button>
            </div>
        </div>


        <div class="flex flex-row w-full">
            <!-- Sidebar user list -->
            <div class=" min-w-[400px] max-w-[400px] bg-[#181818] border rounded-l-md border-gray-400 p-4 space-y-4">
                <div class="flex justify-between items-center space-x-4">
                    <form method="GET" action="manage_instructors.php" class="flex justify-between items-center w-full">
                        <input 
                            type="text" 
                            name="search" 
                            value="<?= htmlspecialchars($search) ?>" 
                            class="border py-2 px-4 rounded-l-md w-full bg-transparent" 
                            placeholder="Search instructors..."
                        >
                        <button type="submit" class="bg-white p-3 rounded-r-md border hover:bg-[#9c9c9c] transition-all duration-300 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" x="0" y="0" viewBox="0 0 612.01 612.01" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M606.209 578.714 448.198 423.228C489.576 378.272 515 318.817 515 253.393 514.98 113.439 399.704 0 257.493 0S.006 113.439.006 253.393s115.276 253.393 257.487 253.393c61.445 0 117.801-21.253 162.068-56.586l158.624 156.099c7.729 7.614 20.277 7.614 28.006 0a19.291 19.291 0 0 0 .018-27.585zM257.493 467.8c-120.326 0-217.869-95.993-217.869-214.407S137.167 38.986 257.493 38.986c120.327 0 217.869 95.993 217.869 214.407S377.82 467.8 257.493 467.8z" fill="#000000" opacity="1" data-original="#000000" class=""></path></g></svg>
                        </button>
                    </form>
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
            <div class="fixed left-[832px] bg-[#181818] border rounded-r-md border-gray-400 h-auto py-4 px-8 space-y-4 w-[400px]">
                <div class="flex flex-row items-center justify-between">
                    <h3 class="text-xl font-bold">
                        <?= $isAddMode ? 'Add New Instructors' : ($isEditMode ? 'Edit Instructors' : 'Instructors Information') ?>
                    </h3>
                    <div class="flex flex-row space-x-4 items-center justify-center">
                        <?php if ($isAddMode || $isEditMode): ?>
                            <a href="manage_instructors.php" class="cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><ellipse cx="256" cy="256" rx="256" ry="255.832" fill="#e21b1b" data-original="#e21b1b"></ellipse><path d="M228.021 113.143h55.991v285.669h-55.991z" transform="rotate(-45.001 256.015 255.982)" fill="#ffffff" data-original="#ffffff"></path><path d="M113.164 227.968h285.669v55.991H113.164z" s transform="rotate(-45.001 255.997 255.968)" fill="#ffffff" data-original="#ffffff"></path></g></svg>
                            </a>
                        <?php elseif ($selectedInstructors): ?>
                            <!-- edit button -->
                            <a href="?edit=true&id=<?= $selectedInstructors['id'] ?>" class="cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><g data-name="Layer 2"><circle cx="256" cy="256" r="256" fill="#26a1f4" opacity="1" data-original="#26a1f4"></circle><g fill="#fff"><path d="m345.15 237.54-.14-.14-70.56-70.61s-86 86-127.44 128.3c-5.16 5.26-9.07 12.58-11.39 19.66-6.8 20.79-12.43 42-18.69 63-1.68 5.63-1.34 10.59 3.07 14.79 4.16 4 8.84 4.14 14.24 2.52 20-6 40.13-11.71 60.22-17.46a61.5 61.5 0 0 0 27.16-16.39c39.48-39.72 123.53-123.67 123.53-123.67zM386.34 149.81l-24.13-24.13a33 33 0 0 0-46.65 0L288.21 153 359 223.81l27.35-27.35a33 33 0 0 0-.01-46.65z" fill="#ffffff" opacity="1" data-original="#ffffff"></path></g></g></g></svg>
                            </a>
                                    <!-- delete button -->
                                    <button 
                                        class="cursor-pointer"
                                        onclick="openDeleteModal(<?= $selectedInstructors['id'] ?>, '<?= htmlspecialchars($selectedInstructors['fullname'], ENT_QUOTES) ?>')">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" x="0" y="0" viewBox="0 0 173.397 173.397" style="enable-background:new 0 0 512 512" xml:space="preserve" fill-rule="evenodd" class=""><g><circle cx="86.699" cy="86.699" r="84.667" fill="#db4437" opacity="1" data-original="#db4437" class=""></circle><g fill="#fff"><path d="m122.819 67.955-6.586 66.354c-.376 3.783-3.256 6.818-7.059 6.818H64.223c-3.802 0-6.683-3.033-7.058-6.818l-6.587-66.354zM71.052 81.06a3.538 3.538 0 0 1 3.334-3.718 3.538 3.538 0 0 1 3.719 3.333l2.275 41.735a3.476 3.476 0 0 1-2.12 3.432c-1.381.599-2.912.291-3.954-.796a3.515 3.515 0 0 1-.978-2.247l-2.276-41.74zm27.96-3.718a3.549 3.549 0 0 1 3.333 3.718l-2.275 41.734a3.476 3.476 0 0 1-2.479 3.18 3.476 3.476 0 0 1-3.844-1.216 3.516 3.516 0 0 1-.73-2.344l2.276-41.739a3.538 3.538 0 0 1 3.718-3.333z" fill="#ffffff" opacity="1" data-original="#ffffff" class=""></path><rect width="86.35" height="12.415" x="43.524" y="53.122" rx="6.207" fill="#ffffff" opacity="1" data-original="#ffffff" class=""></rect><path d="M108.151 53.726h-6.18v-7.94c0-4.035-3.3-7.336-7.335-7.336H78.762c-4.035 0-7.336 3.3-7.336 7.336v7.94h-6.18v-7.94c0-7.446 6.07-13.516 13.515-13.516h15.875c7.445 0 13.515 6.07 13.515 13.515z" fill="#ffffff" opacity="1" data-original="#ffffff" class=""></path></g></g></svg>
                            </button>

                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($isAddMode): ?>
                    <!-- ADD INSTRUCTOR FORM -->
                    <form action="include/instructor_add_process.php" method="POST" class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold mb-1">Full Name</label>
                            <input type="text" name="fullname" class="w-full p-2 rounded bg-[#222] border border-gray-600" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1">Email</label>
                            <input type="email" name="email" class="w-full p-2 rounded bg-[#222] border border-gray-600" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1">Office Hours</label>
                            <input type="text" name="office_hours" class="w-full p-2 rounded bg-[#222] border border-gray-600" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1">Username</label>
                            <input type="text" name="username" class="w-full p-2 rounded bg-[#222] border border-gray-600" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1">Password</label>
                            <input type="password" name="password" class="w-full p-2 rounded bg-[#222] border border-gray-600" required>
                        </div>
                        <button type="submit" class="bg-blue-600 w-full hover:bg-blue-700 px-4 py-2 rounded-md font-semibold cursor-pointer">
                            Add Instructors
                        </button>
                    </form>

                <?php elseif ($isEditMode && $selectedInstructors): ?>
                    <!-- EDIT INSTRUCTOR FORM -->
                    <form action="include/instructor_edit_process.php" method="POST" class="space-y-4">
                        <input type="hidden" name="id" value="<?= $selectedInstructors['id'] ?>">
                        <div>
                            <label class="block text-sm font-semibold mb-1">Full Name</label>
                            <input type="text" name="fullname" value="<?= htmlspecialchars($selectedInstructors['fullname']) ?>" class="w-full p-2 rounded bg-[#222] border border-gray-600" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1">Email</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($selectedInstructors['email']) ?>" class="w-full p-2 rounded bg-[#222] border border-gray-600" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1">Office Hours</label>
                            <input type="text" name="office_hours" value="<?= htmlspecialchars($selectedInstructors['office_hours']) ?>" class="w-full p-2 rounded bg-[#222] border border-gray-600" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1">Username</label>
                            <input type="text" name="username" value="<?= htmlspecialchars($selectedInstructors['username']) ?>" class="w-full p-2 rounded bg-[#222] border border-gray-600" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1">New Password (optional)</label>
                            <input type="password" name="password" class="w-full p-2 rounded bg-[#222] border border-gray-600" placeholder="Leave blank to keep old password">
                        </div>
                        <button type="submit" class="bg-blue-600 w-full hover:bg-blue-700 px-4 py-2 rounded-md font-semibold cursor-pointer">
                            Save Changes
                        </button>
                    </form>

                <?php elseif ($selectedInstructors): ?>
                    <!-- USER INFO -->
                    <div class="space-y-4">
                        <p><span class="font-semibold">ID:</span> <?= htmlspecialchars($selectedInstructors['id']) ?></p>
                        <p><span class="font-semibold">Full Name:</span> <?= htmlspecialchars($selectedInstructors['fullname']) ?></p>
                        <p><span class="font-semibold">Email:</span> <?= htmlspecialchars($selectedInstructors['email']) ?></p>
                        <p><span class="font-semibold">Office Hours:</span> <?= htmlspecialchars($selectedInstructors['office_hours']) ?></p>
                        <p><span class="font-semibold">Username:</span> <?= htmlspecialchars($selectedInstructors['username']) ?></p>
                        <p><span class="font-semibold">Created at:</span> <?= htmlspecialchars($selectedInstructors['created_at']) ?></p>
                    </div>
                <?php else: ?>
                    <p class="text-gray-400">Select a user to view information.</p>
                <?php endif; ?>
            </div>


        </div>
    </main>

    <!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-10 hidden flex items-center justify-center">

    <!-- Semi-transparent overlay -->
    <div class="absolute inset-0 bg-black opacity-90"></div>
    
    <!-- Modal box -->
    <div class="relative bg-[#181818] text-white rounded-lg p-6 w-[400px] shadow-lg z-20">
        <h3 class="text-lg font-bold mb-2">Confirm Delete</h3>
        <p class="mb-4">
            Are you sure you want to delete <br>
            <span id="deleteUserName" class="font-semibold"></span>?
        </p>
        <div class="flex justify-end space-x-3">
            <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-600 rounded hover:bg-gray-700 cursor-pointer">
                Cancel
            </button>
            <button onclick="performDelete()" class="px-4 py-2 bg-red-600 rounded hover:bg-red-700 cursor-pointer">
                Delete
            </button>
        </div>
    </div>
</div>

    <script>
    let deleteTargetId = null;
    function openDeleteModal(id, name) {
        deleteTargetId = id;
        const nameEl = document.getElementById('deleteUserName');
        if (nameEl) nameEl.textContent = name || id;
        const modal = document.getElementById('deleteModal');
        if (modal) modal.classList.remove('hidden');
    }
    function closeDeleteModal() {
        deleteTargetId = null;
        const modal = document.getElementById('deleteModal');
        if (modal) modal.classList.add('hidden');
    }
    function performDelete() {
        if (!deleteTargetId) return;
        // The delete script is under admin/include, so use that relative path.
        window.location.href = 'include/instructor_delete.php?id=' + encodeURIComponent(deleteTargetId);
    }
    </script>
</body>
</html>


