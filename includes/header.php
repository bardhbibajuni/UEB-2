<!DOCTYPE html>
<html>
<head>
    <title>Course Platform</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include 'nav.php'; ?>

<?php
session_start();

// fake login
if (!isset($_SESSION["user_id"])) {
    $_SESSION["user_id"] = 1; 
}
?>