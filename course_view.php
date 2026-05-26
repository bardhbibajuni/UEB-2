<?php
session_start();
require_once 'helpers.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$id     = intval($_GET['id'] ?? 0);
$course = findCourse($id);
$userId = (int)$_SESSION['user']['id'];

if (!$course) {
    header('Location: courses.php');
    exit;
}

if (!hasPurchased($userId, $id) && $_SESSION['user']['role'] !== 'admin') {
    header('Location: buy_course.php?id=' . $id);
    exit;
}

include 'header.php';
?>

<div class="view-wrapper">
    <a href="my_courses.php" style="color:#9ca3af;display:inline-block;margin-bottom:20px;">&larr; My Courses</a>

    <h1 class="title"><?= sanitize($course['title']) ?></h1>
    <p class="subtitle">
        by <?= sanitize($course['instructor']) ?> &nbsp;&bull;&nbsp;
        Added <?= sanitize(substr($course['created_at'], 0, 10)) ?>
    </p>

    <div class="course-content-box">
        <h3>About This Course</h3>
        <p><?= nl2br(sanitize($course['description'])) ?></p>
    </div>

    <?php if (!empty($course['video_url'])): ?>
    <div class="course-content-box">
        <h3>Course Video</h3>
        <div class="video-wrapper">
            <iframe src="<?= sanitize($course['video_url']) ?>"
                    frameborder="0" allowfullscreen
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
            </iframe>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($course['file_path'])): ?>
    <div class="course-content-box">
        <h3>Course Material</h3>
        <?php $ext = strtolower(pathinfo($course['file_path'], PATHINFO_EXTENSION)); ?>
        <?php if ($ext === 'pdf'): ?>
            <iframe src="<?= sanitize($course['file_path']) ?>"
                    style="width:100%;height:500px;border-radius:10px;border:1px solid rgba(255,255,255,0.1);">
            </iframe>
        <?php endif; ?>
        <a href="download.php?id=<?= $id ?>" class="btn-card btn-view" style="display:inline-block;margin-top:12px;">
            Download <?= strtoupper($ext) ?> File
        </a>
    </div>
    <?php else: ?>
    <div class="course-content-box">
        <p style="color:#9ca3af;">Course materials will be uploaded soon.</p>
    </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
