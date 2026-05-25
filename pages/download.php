<?php

include '../includes/functions.php';
session_start();

$user_id = $_SESSION['user']['id'];
$course_id = $_GET["id"];

$courses = include '../data/courses.php';
$purchases = include '../data/purchases.php';

if (!hasPurchased($user_id, $course_id, $purchases)) {
    die("Access denied");
}

$file = null;

foreach ($courses as $course) {
    if ($course["id"] == $course_id) {
        $file = "../" . $course["file"];
        break;
    }
}

if (!$file || !file_exists($file)) {
    die("File not found");
}

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($file) . '"');
readfile($file);
exit;

?>