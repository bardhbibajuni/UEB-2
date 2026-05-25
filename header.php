<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!defined('ROOT_DIR')) {
    require_once __DIR__ . '/helpers.php';
}
?>

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
