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
<html>
<head>
    <title>Course Structure</title>

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
</head>
<body class="bg-gray-900 text-white">

<div class="max-w-4xl mx-auto py-10">

    <h2 class="text-2xl font-semibold mb-6">Course Structure</h2>

    <!-- BUTTON -->
    <div class="flex justify-end mb-4">
        <button class="bg-green-600 px-4 py-2 rounded shadow">New Chapter</button>
    </div>

    <!-- CHAPTER LIST -->
    <div id="chapters" class="space-y-5">

        <?php foreach ($chapters as $chapter): ?>
        <div class="bg-gray-800 rounded-lg p-5" data-id="<?= $chapter['id'] ?>">

            <!-- CHAPTER HEADER -->
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold flex items-center gap-2 cursor-move">
                    ☰ <?= $chapter['title'] ?>
                </h3>

                <div class="space-x-2">
                    <button class="bg-blue-600 px-3 py-1 rounded">✎</button>
                    <button class="bg-red-600 px-3 py-1 rounded">🗑</button>
                </div>
            </div>

            <hr class="my-3 border-gray-600">

            <!-- LESSONS -->
            <ul class="lesson-list space-y-2" id="chapter-<?= $chapter['id'] ?>">

                <?php foreach ($chapter['lessons'] as $lesson): ?>
                <li class="bg-gray-700 p-3 rounded flex justify-between items-center cursor-move" data-id="<?= $lesson['id'] ?>">
                    <span>☰ <?= $lesson['title'] ?></span>
                    <div class="space-x-2">
                        <button class="bg-blue-600 px-3 py-1 rounded">✎</button>
                        <button class="bg-red-600 px-3 py-1 rounded">🗑</button>
                    </div>
                </li>
                <?php endforeach; ?>

            </ul>

            <button class="mt-4 w-full bg-gray-700 py-2 rounded">Create New Lesson</button>
        </div>
        <?php endforeach; ?>

    </div>

</div>

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
