<?php
session_start();
include "../data/data.php";
include "classes/Admin.php";

if ($_SESSION['user']['role'] != "admin") {
    die("Access denied");
}

$admin = new Admin($users, $courses);
$courses = $admin->getCourses();

echo "<h2>Courses</h2>";

foreach ($courses as $course) {
    echo $course['title'];
    echo " <a href='delete_course.php?id=".$course['id']."'>Delete</a><br>";
}