<?php include '../includes/header.php'; ?>

<h1>My Courses</h1>

<?php

$user_id = $_SESSION["user_id"];

$courses = include '../data/courses.php';
$purchases = include '../data/purchases.php';

$my_courses = [];

// find purchased course IDs for this user
foreach ($purchases as $purchase) {
    if ($purchase["user_id"] == $user_id) {
        $my_courses[] = $purchase["course_id"];
    }
}

// show only matching courses
foreach ($courses as $course) {

    if (in_array($course["id"], $my_courses)) {

        echo "<div style='border:1px solid green; padding:10px; margin:10px;'>";
        echo "<h3>{$course['title']}</h3>";
        echo "<p>{$course['description']}</p>";
        echo "</div>";
        echo "<button><a href='course-view.php?id={$course['id']}'>Open Course</a></button>";
    }
}

if (empty($my_courses)) {
    echo "<p>You haven't bought any courses yet.</p>";
}

?>

<?php include '../includes/footer.php'; ?>