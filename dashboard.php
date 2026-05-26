<?php
session_start();
require_once 'helpers.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user       = $_SESSION['user'];
$allCourses = getAllCourses();
$myCourses  = getUserCourses((int)$user['id']);

include 'header.php';
?>

<style>
.dashboard-wrapper { text-align:center; padding:60px 20px; color:white; }
.quote-box {
    margin: 30px auto;
    max-width: 600px;
    background: rgba(99,102,241,0.1);
    border: 1px solid rgba(99,102,241,0.3);
    border-radius: 14px;
    padding: 24px 30px;
    font-style: italic;
    color: #a5b4fc;
    font-size: 15px;
    line-height: 1.6;
    min-height: 60px;
}
.quote-author { color: #6b7280; font-size: 13px; margin-top: 8px; font-style: normal; }
</style>

<div class="dashboard-wrapper">
    <h1 class="title">
        Welcome, <?= sanitize($user['firstname']) . ' ' . sanitize($user['lastname']) ?>!
    </h1>
    <p class="subtitle">Your Brain Boost learning dashboard</p>

    <div class="quote-box" id="quote-box">
        <span style="color:#6b7280;">Loading motivational quote...</span>
    </div>

    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-number"><?= count($allCourses) ?></div>
            <div class="stat-label">Courses Available</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= count($myCourses) ?></div>
            <div class="stat-label">My Courses</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= ucfirst($user['role'] ?? 'user') ?></div>
            <div class="stat-label">Role</div>
        </div>
    </div>

    <div class="dash-links">
        <a href="courses.php"    class="dash-btn">Browse Courses</a>
        <a href="my_courses.php" class="dash-btn">My Courses</a>
        <a href="contact.php"    class="dash-btn">Contact Us</a>

        <?php if (($user['role'] ?? '') === 'admin'): ?>
            <a href="add_course.php"    class="dash-btn">Add Course</a>
            <a href="admin/admin.php"   class="dash-btn">Admin Panel</a>
        <?php endif; ?>
    </div>
</div>

<script>
fetch('https://zenquotes.io/api/random')
    .then(r => r.json())
    .then(data => {
        if (data && data[0]) {
            document.getElementById('quote-box').innerHTML =
                '"' + data[0].q + '"' +
                '<div class="quote-author">— ' + data[0].a + '</div>';
        }
    })
    .catch(() => {
        document.getElementById('quote-box').innerHTML =
            '"The expert in anything was once a beginner."' +
            '<div class="quote-author">— Helen Hayes</div>';
    });

const glow = document.getElementById('glow');
if (glow) {
    document.addEventListener('mousemove', e => {
        glow.style.left = e.clientX + 'px';
        glow.style.top  = e.clientY + 'px';
    });
}
</script>

<?php include 'footer.php'; ?>
