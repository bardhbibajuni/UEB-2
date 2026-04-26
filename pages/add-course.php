<?php include '../includes/header.php'; ?>

<h1>Add Course</h1>

<form method="POST">
    <input type="text" name="title" placeholder="Course title"><br><br>
    <textarea name="description" placeholder="Description"></textarea><br><br>
    <button type="submit">Add</button>
</form>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];
    $description = $_POST["description"];

    $courses = include "../data/courses.php";

    $newCourse = [
        "id" => count($courses) + 1,
        "title" => $title,
        "description" => $description
    ];

    $courses[] = $newCourse;

    file_put_contents(
        "../data/courses.php",
        "<?php return " . var_export($courses, true) . ";"
    );

    echo "<p>Course added!</p>";
}

?>

<?php include '../includes/footer.php'; ?>