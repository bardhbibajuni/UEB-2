<?php
session_start();
require_once 'helpers.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
$allCourses = getData(DATA_DIR . '/courses.php');
$purchases  = getData(DATA_DIR . '/purchases.php');
$myCount = count(array_filter($purchases, fn($p) => $p['user_id'] == $user['id']));

include 'header.php';
?>

<div class="dashboard-wrapper">
    <div class="glow" id="glow"></div>

    <h1 class="title">
        Welcome, <?= sanitize($user['firstname']) . ' ' . sanitize($user['lastname']) ?>!
    </h1>
    <p class="subtitle">
        <?php if (isset($_COOKIE['brain_boost_user'])): ?>
            Good to see you again, <?= sanitize($_COOKIE['brain_boost_user']) ?>!
        <?php else: ?>
            Your Brain Boost Dashboard
        <?php endif; ?>
    </p>

    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-number"><?= count($allCourses) ?></div>
            <div class="stat-label">Courses Available</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $myCount ?></div>
            <div class="stat-label">My Courses</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= ucfirst($user['role']) ?></div>
            <div class="stat-label">Role</div>
        </div>
    </div>

    <div class="dash-links">
        <a href="courses.php" class="dash-btn">Browse Courses</a>
        <a href="my_courses.php" class="dash-btn">My Courses</a>
        <?php if ($user['role'] === 'admin'): ?>
            <a href="add_course.php" class="dash-btn">Add Course</a>
            <a href="admin/admin.php" class="dash-btn dash-btn-admin">Admin Panel</a>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
