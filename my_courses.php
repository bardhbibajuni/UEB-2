<?php
session_start();
require_once 'helpers.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$myCourses = getUserCourses((int)$_SESSION['user']['id']);

include 'header.php';
?>

<div class="courses-section">
    <h1 class="section-title">My Courses</h1>

    <?php if (empty($myCourses)): ?>
        <div style="text-align:center;margin-top:60px;">
            <p class="subtitle">You haven't purchased any courses yet.</p>
            <a href="courses.php">
                <button class="btn" style="background:linear-gradient(135deg,#00ffff,#6366f1);margin-top:20px;">
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
            <?php if (!empty($course['file_path'])): ?>
                <a href="download.php?id=<?= $course['id'] ?>" class="btn-card btn-edit" style="margin-top:6px;">Download</a>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
