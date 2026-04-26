<?php include '../includes/header.php'; ?>
<?php include '../includes/functions.php'; ?>

<?php

$user_id = $_SESSION["user_id"];
$course_id = $_GET["id"];

$courses = include '../data/courses.php';
$purchases = include '../data/purchases.php';

// find course
$course = null;
foreach ($courses as $c) {
    if ($c["id"] == $course_id) {
        $course = $c;
        break;
    }
}

if (!$course) {
    die("Course not found");
}

// ACCESS CHECK
if (!hasPurchased($user_id, $course_id, $purchases)) {
    die("Access denied. You must buy this course first.");
}

?>

<a href="download.php?id=<?= $course_id ?>">
    Download Course
</a>

<h1><?= $course["title"] ?></h1>
<p><?= $course["description"] ?></p>

<p>🎥 Course content goes here (video/pdf later)</p>

<?php include '../includes/footer.php'; ?>