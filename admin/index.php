

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
    
    <!-- sidebar section-->
    <section class="w-[350px] bg-[#181818] h-screen fixed top-0 left-0 flex flex-col">
        <div class="mx-8 mt-4 space-y-2 ">
            <!-- header -->
            <h3 class="font-bold">Administrator</h3>

            <!-- Link -->
            <a href="manage_course.php" class="border-b border-gray-300 flex flex-row justify-between items-center shadow-lg py-2 px-2  hover:bg-gray-800 hover:rounded-lg transition-all duration-300">
                <div class="flex flex-row space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M466.6 199.1c-8.3-11.3-21.1-17.8-35.1-17.8h-10.6v-28.5c0-24-19.5-43.5-43.6-43.5H250.1c-7.3 0-14.3-2.9-19.5-8l-20-19.9c-8.2-8.2-19.1-12.7-30.7-12.7H80.5c-24 0-43.5 19.5-43.5 43.6V366c-.3 9.7 2.6 19.3 8.5 27.3 8.4 11.4 21.3 18 35.5 18h305.9c19.1 0 35.8-12.3 41.6-30.6l44.7-142.9c4.1-13.3 1.7-27.4-6.6-38.7zM52.9 112.3c0-15.2 12.4-27.6 27.5-27.6h99.5c7.3 0 14.2 2.9 19.5 8l20 19.9c8.2 8.2 19.1 12.7 30.7 12.7h127.3c15.2 0 27.6 12.4 27.6 27.5v28.5H125c-19.1 0-35.8 12.3-41.6 30.5l-30.6 97.6V112.3zm404.9 120.8L413.1 376c-3.6 11.6-14.2 19.3-26.3 19.3H80.9c-9 0-17.2-4.2-22.6-11.4-5.3-7.3-6.9-16.4-4.2-25l44.5-142.3c3.6-11.6 14.2-19.3 26.3-19.3h306.5c8.9 0 17 4.1 22.2 11.2 5.4 7.2 6.9 16.1 4.2 24.6z" fill="#ffffff" opacity="1" data-original="#000000" class=""></path></g></svg>
                    <!-- Description -->
                    <span class="text-[15px]">Course Management</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" x="0" y="0" viewBox="0 0 492.004 492.004" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M382.678 226.804 163.73 7.86C158.666 2.792 151.906 0 144.698 0s-13.968 2.792-19.032 7.86l-16.124 16.12c-10.492 10.504-10.492 27.576 0 38.064L293.398 245.9l-184.06 184.06c-5.064 5.068-7.86 11.824-7.86 19.028 0 7.212 2.796 13.968 7.86 19.04l16.124 16.116c5.068 5.068 11.824 7.86 19.032 7.86s13.968-2.792 19.032-7.86L382.678 265c5.076-5.084 7.864-11.872 7.848-19.088.016-7.244-2.772-14.028-7.848-19.108z" fill="#ffffff" opacity="1" data-original="#000000"></path></g></svg>
            </a>

            <a href="manage_user.php" class="border-b border-gray-300 flex flex-row justify-between items-center shadow-lg py-2 px-2  hover:bg-gray-800  hover:rounded-lg transition-all duration-300">
                        <div class="flex flex-row space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M466.6 199.1c-8.3-11.3-21.1-17.8-35.1-17.8h-10.6v-28.5c0-24-19.5-43.5-43.6-43.5H250.1c-7.3 0-14.3-2.9-19.5-8l-20-19.9c-8.2-8.2-19.1-12.7-30.7-12.7H80.5c-24 0-43.5 19.5-43.5 43.6V366c-.3 9.7 2.6 19.3 8.5 27.3 8.4 11.4 21.3 18 35.5 18h305.9c19.1 0 35.8-12.3 41.6-30.6l44.7-142.9c4.1-13.3 1.7-27.4-6.6-38.7zM52.9 112.3c0-15.2 12.4-27.6 27.5-27.6h99.5c7.3 0 14.2 2.9 19.5 8l20 19.9c8.2 8.2 19.1 12.7 30.7 12.7h127.3c15.2 0 27.6 12.4 27.6 27.5v28.5H125c-19.1 0-35.8 12.3-41.6 30.5l-30.6 97.6V112.3zm404.9 120.8L413.1 376c-3.6 11.6-14.2 19.3-26.3 19.3H80.9c-9 0-17.2-4.2-22.6-11.4-5.3-7.3-6.9-16.4-4.2-25l44.5-142.3c3.6-11.6 14.2-19.3 26.3-19.3h306.5c8.9 0 17 4.1 22.2 11.2 5.4 7.2 6.9 16.1 4.2 24.6z" fill="#ffffff" opacity="1" data-original="#000000" class=""></path></g></svg>
                            <!-- Description -->
                            <span class="text-[15px]">User Management</span>
                        </div>
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" x="0" y="0" viewBox="0 0 492.004 492.004" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M382.678 226.804 163.73 7.86C158.666 2.792 151.906 0 144.698 0s-13.968 2.792-19.032 7.86l-16.124 16.12c-10.492 10.504-10.492 27.576 0 38.064L293.398 245.9l-184.06 184.06c-5.064 5.068-7.86 11.824-7.86 19.028 0 7.212 2.796 13.968 7.86 19.04l16.124 16.116c5.068 5.068 11.824 7.86 19.032 7.86s13.968-2.792 19.032-7.86L382.678 265c5.076-5.084 7.864-11.872 7.848-19.088.016-7.244-2.772-14.028-7.848-19.108z" fill="#ffffff" opacity="1" data-original="#000000"></path></g></svg>
            </a>

                <a href="#" class="border-b border-gray-300 flex flex-row justify-between items-center shadow-lg py-2 px-2  hover:bg-gray-800  hover:rounded-lg transition-all duration-300">
                        <div class="flex flex-row space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M466.6 199.1c-8.3-11.3-21.1-17.8-35.1-17.8h-10.6v-28.5c0-24-19.5-43.5-43.6-43.5H250.1c-7.3 0-14.3-2.9-19.5-8l-20-19.9c-8.2-8.2-19.1-12.7-30.7-12.7H80.5c-24 0-43.5 19.5-43.5 43.6V366c-.3 9.7 2.6 19.3 8.5 27.3 8.4 11.4 21.3 18 35.5 18h305.9c19.1 0 35.8-12.3 41.6-30.6l44.7-142.9c4.1-13.3 1.7-27.4-6.6-38.7zM52.9 112.3c0-15.2 12.4-27.6 27.5-27.6h99.5c7.3 0 14.2 2.9 19.5 8l20 19.9c8.2 8.2 19.1 12.7 30.7 12.7h127.3c15.2 0 27.6 12.4 27.6 27.5v28.5H125c-19.1 0-35.8 12.3-41.6 30.5l-30.6 97.6V112.3zm404.9 120.8L413.1 376c-3.6 11.6-14.2 19.3-26.3 19.3H80.9c-9 0-17.2-4.2-22.6-11.4-5.3-7.3-6.9-16.4-4.2-25l44.5-142.3c3.6-11.6 14.2-19.3 26.3-19.3h306.5c8.9 0 17 4.1 22.2 11.2 5.4 7.2 6.9 16.1 4.2 24.6z" fill="#ffffff" opacity="1" data-original="#000000" class=""></path></g></svg>
                            <!-- Description -->
                            <span class="text-[15px]">Certificate Management</span>
                        </div>
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" x="0" y="0" viewBox="0 0 492.004 492.004" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M382.678 226.804 163.73 7.86C158.666 2.792 151.906 0 144.698 0s-13.968 2.792-19.032 7.86l-16.124 16.12c-10.492 10.504-10.492 27.576 0 38.064L293.398 245.9l-184.06 184.06c-5.064 5.068-7.86 11.824-7.86 19.028 0 7.212 2.796 13.968 7.86 19.04l16.124 16.116c5.068 5.068 11.824 7.86 19.032 7.86s13.968-2.792 19.032-7.86L382.678 265c5.076-5.084 7.864-11.872 7.848-19.088.016-7.244-2.772-14.028-7.848-19.108z" fill="#ffffff" opacity="1" data-original="#000000"></path></g></svg>
            </a>
        </div>
    </section>

</body>
</html>