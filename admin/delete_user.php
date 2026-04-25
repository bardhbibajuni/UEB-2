<?php
session_start();
include "../db.php";

// if ($_SESSION['is_admin'] != 1) {
//     die("Access denied");
// }

$id = (int) $_GET['id'];

mysqli_query($conn, "DELETE FROM users WHERE id=$id");

header("Location: users.php");
?>