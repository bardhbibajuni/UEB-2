<!DOCTYPE html>
<html>
<head>
    <title>Course Platform</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<?php
session_start();
require_once __DIR__ . '/../helpers.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}
?>

<?php include 'nav.php'; ?>
