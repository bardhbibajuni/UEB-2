<?php include '../includes/header.php'; ?>

<h1>Courses</h1>

<?php
$courses = include '../data/courses.php';

foreach ($courses as $course) {
    echo "<div style='border:1px solid #ccc; padding:10px; margin:10px;'>";
    echo "<h3>{$course['title']}</h3>";
    echo "<p>{$course['description']}</p>";
    echo "</div>";
}
?>

<?php include '../includes/footer.php'; ?>