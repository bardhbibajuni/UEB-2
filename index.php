<?php
session_start();
require_once 'helpers.php';
include 'header.php';

$courses = getAllCourses();
?>

<div class="home-container">
    <div>
        <h1 class="home-title">Brain Boost 🧠</h1>
        <p class="home-text">Learn smarter. Build faster. Think better.</p>

        <div style="margin-top:35px; display:flex; flex-direction:column; gap:15px; align-items:center;">

            <?php if (!isset($_SESSION['user'])): ?>

                <a href="register.php">
                    <button class="btn" style="background:linear-gradient(135deg,#ff00ff,#6366f1);">
                        Get Started
                    </button>
                </a>

                <a href="login.php">
                    <button class="btn" style="background:linear-gradient(135deg,#00ffff,#6366f1);">
                        Login
                    </button>
                </a>

            <?php else: ?>

                <a href="courses.php">
                    <button class="btn" style="background:linear-gradient(135deg,#00ffff,#6366f1);">
                        Browse Courses
                    </button>
                </a>

            <?php endif; ?>

        </div>
    </div>
</div>

<?php if (!empty($courses) && is_array($courses)): ?>
<div class="courses-section">

    <h2 class="section-title">
        <?= isset($_SESSION['user']) ? 'Available Courses' : 'Featured Courses' ?>
    </h2>

    <div class="courses-grid">

        <?php foreach ($courses as $course): ?>
        <div class="course-card">

            <div class="course-icon">📚</div>

            <h3><?= sanitize($course['title'] ?? 'No Title') ?></h3>

            <p class="course-desc">
                <?= sanitize($course['description'] ?? 'No Description') ?>
            </p>

            <div class="course-meta">
                <span class="course-price">
                    $<?= number_format((float)($course['price'] ?? 0), 2) ?>
                </span>

                <span class="course-instructor">
                    by <?= sanitize($course['instructor'] ?? 'Unknown') ?>
                </span>
            </div>

            <?php if (isset($_SESSION['user'])): ?>

                <?php
                $userId   = $_SESSION['user']['id'] ?? null;
                $courseId = $course['id'] ?? null;
                $purchased = ($userId && $courseId) ? hasPurchased((int)$userId, (int)$courseId) : false;
                ?>

                <?php if ($purchased): ?>
                    <a href="course_view.php?id=<?= $courseId ?>" class="btn-card btn-view">
                        Open Course
                    </a>
                <?php else: ?>
                    <a href="buy_course.php?id=<?= $courseId ?>" class="btn-card btn-buy">
                        Buy Now
                    </a>
                <?php endif; ?>

            <?php else: ?>
                <a href="login.php" class="btn-card btn-buy">
                    Login to Buy
                </a>
            <?php endif; ?>

        </div>
        <?php endforeach; ?>

    </div>
</div>
<?php endif; ?>

<?php include 'footer.php'; ?>
