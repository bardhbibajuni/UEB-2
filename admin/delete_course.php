<?php
session_start();
include "../db.php";
include "classes/Admin.php";

// if ($_SESSION['is_admin'] != 1) {
//     die("Access denied");
// }

$admin = new Admin($conn);

$admin->deleteCourse($_GET['id']);

header("Location: admin.php");
?>