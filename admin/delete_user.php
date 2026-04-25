<?php
session_start();
include "../data/data.php";
include "classes/Admin.php";

if ($_SESSION['user']['role'] != "admin") {
    die("Access denied");
}

$admin = new Admin($users, $courses);

// simulim
$admin->deleteUser($_GET['id']);

header("Location: users.php");