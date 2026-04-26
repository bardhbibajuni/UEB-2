<?php
session_start();
include "../data/data.php";
include "classes/Admin.php";

if ($_SESSION['user']['role'] != "admin") {
    die("Access denied");
}

$admin = new Admin($users, $courses);

$admin->deleteCourse($_GET['id']);

header("Location: admin.php");