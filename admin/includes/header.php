<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../helpers.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin – Brain Boost</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="bg"></div>
<div class="glow" id="glow"></div>

<nav>
    <div class="logo">Brain Boost Admin</div>
    <div>
        <a href="../index.php">← Site</a>
        <a href="admin.php">Dashboard</a>
        <a href="users.php">Users</a>
        <a href="courses.php">Courses</a>
        <a href="messages.php">Messages</a>
        <a href="../logout.php" class="logout-btn">Logout</a>
    </div>
</nav>

<script>
const glow = document.getElementById('glow');
if (glow) document.addEventListener('mousemove', e => {
    glow.style.left = e.clientX + 'px'; glow.style.top = e.clientY + 'px';
});
</script>
