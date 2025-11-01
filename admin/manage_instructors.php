<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../dist/style.css">
    <link rel="stylesheet" href="../public/gen.css">
</head>
<body class="bg-[#121212] text-white">
    <!-- sidebar section -->
    <section class="fixed z-50 h-full">
        <a href="index.php" class="flex items-start justify-center top-0 left-0 w-[50px] h-screen bg-[#404040] border-r  hover:bg-gray-800 transition-all duration-300">
            <p class="text-white [writing-mode:vertical-rl] rotate-0 font-semibold p-4">Administrator</p>
        </a>
    </section>

    <!-- Management -->
    <main class="relative h-screen w-auto space-y-4 flex flex-col items-start justify-start ml-[50px] p-8">
        <h2 class="font-bold text-2xl">User Management</h2>
        <div class="inline-flex rounded-md border border-gray-300 overflow-hidden">
            <Button class="bg-transparent py-2 px-6"><a href="manage_user.php">User</a></Button>
            <Button class="py-2 px-6 text-black bg-white"><a href="">Instructors</a></Button>
        </div>

        <!-- User-->
        <div>
            <!-- User name -->
            <div>
            </div>

            <!-- User Information -->
            <div>

            </div>
        </div>
    </main>
</body>
</html>