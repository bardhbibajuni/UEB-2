<?php
session_start();
require_once 'helpers.php';
include 'header.php';

$courses = getData(DATA_DIR . '/courses.php');
$search  = trim($_GET['search'] ?? '');

if ($search !== '') {
    $courses = array_filter($courses, function($c) use ($search) {
        return stripos($c['title'], $search) !== false
            || stripos($c['description'], $search) !== false;
    });
}
?>

<div class="courses-section">
    <h1 class="section-title">All Courses</h1>

    <form method="GET" class="search-form">
        <input type="text" name="search" placeholder="Search courses..." value="<?= sanitize($search) ?>">
        <button type="submit">Search</button>
        <?php if ($search): ?>
            <a href="courses.php" style="color:#9ca3af; margin-left:10px;">Clear</a>
        <?php endif; ?>
    </form>

    <?php if (empty($courses)): ?>
        <p class="subtitle" style="text-align:center; margin-top:40px;">
            No courses found<?= $search ? ' for "' . sanitize($search) . '"' : '' ?>.
        </p>
    <?php else: ?>
    <div class="courses-grid">
        <?php foreach ($courses as $course): ?>
        <div class="course-card">
            <div class="course-icon">📚</div>
            <h3><?= sanitize($course['title']) ?></h3>
            <p class="course-desc"><?= sanitize($course['description']) ?></p>
            <div class="course-meta">
                <span class="course-price">$<?= number_format($course['price'], 2) ?></span>
                <span class="course-instructor">by <?= sanitize($course['instructor']) ?></span>
            </div>

            <?php if (isset($_SESSION['user'])): ?>
                <?php $purchased = hasPurchased($_SESSION['user']['id'], $course['id']); ?>
                <div style="display:flex; gap:8px; flex-wrap:wrap; justify-content:center;">
                    <?php if ($purchased): ?>
                        <a href="course_view.php?id=<?= $course['id'] ?>" class="btn-card btn-view">Open Course</a>
                    <?php else: ?>
                        <a href="buy_course.php?id=<?= $course['id'] ?>" class="btn-card btn-buy">Buy - $<?= number_format($course['price'], 2) ?></a>
                    <?php endif; ?>

                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                        <a href="edit_course.php?id=<?= $course['id'] ?>" class="btn-card btn-edit">Edit</a>
                        <a href="delete_course.php?id=<?= $course['id'] ?>"
                           class="btn-card btn-delete"
                           onclick="return confirm('Delete this course?')">Delete</a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <a href="login.php" class="btn-card btn-buy">Login to Buy</a>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
