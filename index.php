<?php
session_start();
require_once 'helpers.php';
include 'header.php';
?>

<?php if (!isset($_SESSION['user'])): ?>
    <div class="home-container">
        <div>
            <h1 class="home-title">Brain Boost</h1>
            <p class="home-text">Learn smarter. Build faster. Think better.</p>
            <div style="margin-top:35px; display:flex; flex-direction:column; gap:15px; align-items:center;">
                <a href="register.php">
                    <button class="btn" style="background:linear-gradient(135deg,#ff00ff,#6366f1);">Get Started</button>
                </a>
                <a href="login.php">
                    <button class="btn" style="background:linear-gradient(135deg,#00ffff,#6366f1);">Login</button>
                </a>
            </div>
        </div>
    </div>
<?php else: ?>

    </div>
    <div style="padding:60px 40px 20px; text-align:center;">
        <h1 class="home-title" style="font-size:2.5rem;">
            Welcome back, <?= sanitize($_SESSION['user']['firstname']) ?>!
        </h1>
        <p class="home-text">Browse our latest courses and keep learning.</p>
    </div>

<?php endif; ?>

<?php if (!empty($courses)): ?>
    <div class="courses-section">
        <h2 class="section-title">
            <?= isset($_SESSION['user']) ? 'Available Courses' : 'Featured Courses' ?>
        </h2>
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
                        <?php if ($purchased): ?>
                            <a href="course_view.php?id=<?= $course['id'] ?>" class="btn-card btn-view">Open Course</a>
                        <?php else: ?>
                            <a href="buy_course.php?id=<?= $course['id'] ?>" class="btn-card btn-buy">Buy Now</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="login.php" class="btn-card btn-buy">Login to Buy</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>