<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!defined('ROOT_DIR')) require_once __DIR__ . '/helpers.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Brain Boost</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="bg"></div>
<div class="glow" id="glow"></div>

<nav>
    <div class="logo">Brain Boost</div>
    <div>
        <a href="index.php">Home</a>
        <a href="courses.php">Courses</a>
        <a href="contact.php">Contact</a>

        <?php if (isset($_SESSION['user'])): ?>
            <a href="my_courses.php">My Courses</a>
            <a href="dashboard.php">Dashboard</a>

            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <a href="add_course.php">Add Course</a>
                <a href="admin/admin.php">Admin</a>
            <?php endif; ?>

            <a href="logout.php" class="logout-btn">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </div>
</nav>

<script>
const glow = document.getElementById('glow');
if (glow) {
    document.addEventListener('mousemove', e => {
        glow.style.left = e.clientX + 'px';
        glow.style.top  = e.clientY + 'px';
    });
}
</script>
