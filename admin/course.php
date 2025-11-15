<?php
// SAMPLE DATA — replace with your DB data
$chapters = [
    [
        "id" => 1,
        "title" => "Introduction to Ai",
        "lessons" => [
            ["id" => 11, "title" => "Beginner Design exploration in Adobe Illustrator"],
            ["id" => 12, "title" => "Exercise no.1"],
            ["id" => 13, "title" => "Activity no.1"]
        ]
    ],
    [
        "id" => 2,
        "title" => "Introduction to Ai",
        "lessons" => [
            ["id" => 21, "title" => "Assessment"]
        ]
    ],
    [
        "id" => 3,
        "title" => "New Chapter",
        "lessons" => []
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management - LMS for Ai</title>
    <link rel="stylesheet" href="../dist/style.css">
    <link rel="stylesheet" href="../public/gen.css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
</head>
<body class="bg-[#121212] text-white">
    <section class="ml-[400px] mt-10 max-w-7xl ">
        <!-- Title -->
        <h1 class="text-2xl font-bold">Course Structure</h1>
        <h3 class="text-[#9c9c9c]">Here your can update your course strucuture.</h3>
        <!-- Chapters -->
        <div class="flex flex-row justify-between items-center p-8 border rounded-t-lg bg-[#1e1e1e] mt-6">
            <h2 class="text-xl font-bold">Chapters</h2>
            <button class="btn btn-primary cursor-pointer">New Chapter</button>
        </div>
        <!-- Lessons and Chapters List -->
   <div id="chapters" class=" space-y-5  mx-auto py-4 px-8 border rounded-b-lg bg-[#1e1e1e]">

        <?php foreach ($chapters as $chapter): ?>
        <div class="bg-transparent border  shadow-lg shadow-[rgba(0,0,0,0.2)] rounded-lg p-5" data-id="<?= $chapter['id'] ?>">
            
            <!-- CHAPTER HEADER -->
            <div class="flex  justify-between items-center my-2">
                <h3 class=" text-l font-semibold flex items-center gap-2 cursor-move">
                    ☰ <?= $chapter['title'] ?>
                </h3>

                <div class="space-x-2 flex flex-row justify-center ">
                    <button class="cursor-pointer cursor-pointer border rounded bg-[#636FF2] border-white">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><g data-name="Layer 2"><circle cx="256" cy="256" r="256" fill="transparent" opacity="1" data-original="#26a1f4"></circle><g fill="#fff"><path d="m345.15 237.54-.14-.14-70.56-70.61s-86 86-127.44 128.3c-5.16 5.26-9.07 12.58-11.39 19.66-6.8 20.79-12.43 42-18.69 63-1.68 5.63-1.34 10.59 3.07 14.79 4.16 4 8.84 4.14 14.24 2.52 20-6 40.13-11.71 60.22-17.46a61.5 61.5 0 0 0 27.16-16.39c39.48-39.72 123.53-123.67 123.53-123.67zM386.34 149.81l-24.13-24.13a33 33 0 0 0-46.65 0L288.21 153 359 223.81l27.35-27.35a33 33 0 0 0-.01-46.65z" fill="#ffffff" opacity="1" data-original="#ffffff"></path></g></g></g></svg> 
                    </button>
            <button class="cursor-pointer bg-[#ff0000] border-white border rounded ">                               
               <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" x="0" y="0" viewBox="0 0 173.397 173.397" style="enable-background:new 0 0 512 512" xml:space="preserve" fill-rule="evenodd" class=""><g><circle cx="86.699" cy="86.699" r="84.667" fill="transparent" opacity="1" data-original="#db4437" class=""></circle><g fill="#fff"><path d="m122.819 67.955-6.586 66.354c-.376 3.783-3.256 6.818-7.059 6.818H64.223c-3.802 0-6.683-3.033-7.058-6.818l-6.587-66.354zM71.052 81.06a3.538 3.538 0 0 1 3.334-3.718 3.538 3.538 0 0 1 3.719 3.333l2.275 41.735a3.476 3.476 0 0 1-2.12 3.432c-1.381.599-2.912.291-3.954-.796a3.515 3.515 0 0 1-.978-2.247l-2.276-41.74zm27.96-3.718a3.549 3.549 0 0 1 3.333 3.718l-2.275 41.734a3.476 3.476 0 0 1-2.479 3.18 3.476 3.476 0 0 1-3.844-1.216 3.516 3.516 0 0 1-.73-2.344l2.276-41.739a3.538 3.538 0 0 1 3.718-3.333z" fill="#ffffff" opacity="1" data-original="#ffffff" class=""></path><rect width="86.35" height="12.415" x="43.524" y="53.122" rx="6.207" fill="#ffffff" opacity="1" data-original="#ffffff" class=""></rect><path d="M108.151 53.726h-6.18v-7.94c0-4.035-3.3-7.336-7.335-7.336H78.762c-4.035 0-7.336 3.3-7.336 7.336v7.94h-6.18v-7.94c0-7.446 6.07-13.516 13.515-13.516h15.875c7.445 0 13.515 6.07 13.515 13.515z" fill="#ffffff" opacity="1" data-original="#ffffff" class=""></path></g></g></svg>
            </button>
                </div>
            </div>

            <hr class="my-3 border-gray-300">

            <!-- LESSONS -->
            <ul class="lesson-list space-y-4  " id="chapter-<?= $chapter['id'] ?>">

                <?php foreach ($chapter['lessons'] as $lesson): ?>
                <li class="bg-[#2e2e2e] shadow-lg shadow-[rgba(0,0,0,0.2)] hover:bg-[#3e3e3e] p-3 rounded flex justify-between items-center cursor-move " data-id="<?= $lesson['id'] ?>">
                    <span>☰ <?= $lesson['title'] ?></span>
                    <div class="flex flex-row justify-center space-x-2 ">
                        <button class="cursor-pointer border rounded bg-[#636FF2] border-white">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><g data-name="Layer 2"><circle cx="256" cy="256" r="256" fill="transparent" opacity="1" data-original="#26a1f4"></circle><g fill="#fff"><path d="m345.15 237.54-.14-.14-70.56-70.61s-86 86-127.44 128.3c-5.16 5.26-9.07 12.58-11.39 19.66-6.8 20.79-12.43 42-18.69 63-1.68 5.63-1.34 10.59 3.07 14.79 4.16 4 8.84 4.14 14.24 2.52 20-6 40.13-11.71 60.22-17.46a61.5 61.5 0 0 0 27.16-16.39c39.48-39.72 123.53-123.67 123.53-123.67zM386.34 149.81l-24.13-24.13a33 33 0 0 0-46.65 0L288.21 153 359 223.81l27.35-27.35a33 33 0 0 0-.01-46.65z" fill="#ffffff" opacity="1" data-original="#ffffff"></path></g></g></g></svg>
                        </button>
                        <button class="bg-[#ff0000] border-white border rounded cursor-pointer">                         
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" x="0" y="0" viewBox="0 0 173.397 173.397" style="enable-background:new 0 0 512 512" xml:space="preserve" fill-rule="evenodd" class=""><g><circle cx="86.699" cy="86.699" r="84.667" fill="transparent" opacity="1" data-original="#db4437" class=""></circle><g fill="#fff"><path d="m122.819 67.955-6.586 66.354c-.376 3.783-3.256 6.818-7.059 6.818H64.223c-3.802 0-6.683-3.033-7.058-6.818l-6.587-66.354zM71.052 81.06a3.538 3.538 0 0 1 3.334-3.718 3.538 3.538 0 0 1 3.719 3.333l2.275 41.735a3.476 3.476 0 0 1-2.12 3.432c-1.381.599-2.912.291-3.954-.796a3.515 3.515 0 0 1-.978-2.247l-2.276-41.74zm27.96-3.718a3.549 3.549 0 0 1 3.333 3.718l-2.275 41.734a3.476 3.476 0 0 1-2.479 3.18 3.476 3.476 0 0 1-3.844-1.216 3.516 3.516 0 0 1-.73-2.344l2.276-41.739a3.538 3.538 0 0 1 3.718-3.333z" fill="#ffffff" opacity="1" data-original="#ffffff" class=""></path><rect width="86.35" height="12.415" x="43.524" y="53.122" rx="6.207" fill="#ffffff" opacity="1" data-original="#ffffff" class=""></rect><path d="M108.151 53.726h-6.18v-7.94c0-4.035-3.3-7.336-7.335-7.336H78.762c-4.035 0-7.336 3.3-7.336 7.336v7.94h-6.18v-7.94c0-7.446 6.07-13.516 13.515-13.516h15.875c7.445 0 13.515 6.07 13.515 13.515z" fill="#ffffff" opacity="1" data-original="#ffffff" class=""></path></g></g></svg></button>
                    </div>
                </li>
                <?php endforeach; ?>

            </ul>

            <button class="mt-4 w-full bg-[#2e2e2e] py-2 rounded cursor-pointer border border-gray-300  hover:bg-[#3e3e3e]">Create New Lesson</button>
        </div>
        <?php endforeach; ?>

    </div>
    </section>
     

    <script>
/* ---------------------------------------------------
   DRAGGABLE CHAPTERS
--------------------------------------------------- */
new Sortable(document.getElementById('chapters'), {
    animation: 150,
    handle: ".cursor-move",
    onEnd: function (evt) {
        console.log("Chapters rearranged");
        // TODO: send AJAX to save new order
    }
});

/* ---------------------------------------------------
   DRAGGABLE LESSONS for EACH CHAPTER
--------------------------------------------------- */
document.querySelectorAll(".lesson-list").forEach(list => {
    new Sortable(list, {
        animation: 150,
        handle: ".cursor-move",
        onEnd: function (evt) {
            console.log("Lessons rearranged for chapter", list.id);
            // TODO: send AJAX to save new order
        }
    });
});
</script>
</body>
</html>