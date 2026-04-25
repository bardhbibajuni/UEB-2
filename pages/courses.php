<?php include '../includes/header.php'; ?>

<h1>Courses</h1>

<?php
$courses = include '../data/courses.php';

foreach ($courses as $course) {

    echo "<div style='border:1px solid #ccc; padding:10px; margin:10px;'>";
    echo "<h3>{$course['title']}</h3>";
    echo "<p>{$course['description']}</p>";

    echo "<form method='POST' action='buy-course.php'>";
    echo "<input type='hidden' name='course_id' value='{$course['id']}'>";
    echo "<button type='submit'>Buy Course</button>";
    echo "</form>";

    echo "</div>";
}
?>

<?php include '../includes/footer.php'; ?>

