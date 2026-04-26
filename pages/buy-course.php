<?php

session_start();
require_once __DIR__ . '/../helpers.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

$user_id = $_SESSION['user']['id'];
$course_id = $_POST["course_id"];
$date = date("Y-m-d");

$purchases = include "../data/purchases.php";

// shikon nese eshte e blere me pare
foreach ($purchases as $p) {
    if ($p["user_id"] == $user_id && $p["course_id"] == $course_id) {
        die("You already bought this course.<br><a href='courses.php'>Go back</a>");
    }
}

// shton nje blerje te re
$purchases[] = [
    "user_id" => $user_id,
    "course_id" => $course_id,
    "date" => $date
];

// e ruan ne file
file_put_contents(
    "../data/purchases.php",
    "<?php return " . var_export($purchases, true) . ";"
);

echo "Course purchased successfully!";
echo "<br><a href='courses.php'>Go back</a>";
?>