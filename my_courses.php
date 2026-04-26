<?php
session_start();
require_once 'helpers.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$userId    = $_SESSION['user']['id'];
$purchases = getData(DATA_DIR . '/purchases.php');
$allCourses = getData(DATA_DIR . '/courses.php');

$myIds = array_column(
    array_filter($purchases, fn($p) => $p['user_id'] == $userId),
    'course_id'
);

$myCourses = array_filter($allCourses, fn($c) => in_array($c['id'], $myIds));

include 'header.php';
?>

<div class="courses-section">
    <h1 class="section-title">My Courses</h1>

    <?php if (empty($myCourses)): ?>
        <div style="text-align:center; margin-top:60px;">
            <p class="subtitle">You haven't purchased any courses yet.</p>
            <a href="courses.php">
                <button class="btn" style="background:linear-gradient(135deg,#00ffff,#6366f1); margin-top:20px;">
                    Browse Courses
                </button>
            </a>
        </div>
    <?php else: ?>
    <div class="courses-grid">
        <?php foreach ($myCourses as $course): ?>
        <div class="course-card">
            <div class="course-icon">✅</div>
            <h3><?= sanitize($course['title']) ?></h3>
            <p class="course-desc"><?= sanitize($course['description']) ?></p>
            <div class="course-meta">
                <span class="course-instructor">by <?= sanitize($course['instructor']) ?></span>
            </div>
            <a href="course_view.php?id=<?= $course['id'] ?>" class="btn-card btn-view">Open Course</a>
            <?php if (!empty($course['file'])): ?>
                <a href="download.php?id=<?= $course['id'] ?>" class="btn-card btn-edit" style="margin-top:6px;">Download</a>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
