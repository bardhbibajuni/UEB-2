<?php
session_start();
require_once 'helpers.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$id     = intval($_GET['id'] ?? 0);
$course = findCourse($id);

if (!$course) {
    header('Location: courses.php');
    exit;
}

$userId = (int)$_SESSION['user']['id'];

if (hasPurchased($userId, $id)) {
    header('Location: course_view.php?id=' . $id);
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_buy'])) {
    try {
        if (createPurchase($userId, $id)) {
            header('Location: course_view.php?id=' . $id);
            exit;
        }
        $error = 'Purchase failed. Please try again.';
    } catch (Exception $e) {
        $error = 'Server error. Please try again.';
        error_log('buy_course error: ' . $e->getMessage());
    }
}

include 'header.php';
?>

<div class="form-wrapper">
    <div class="card wide-card" style="max-width:520px;text-align:center;">
        <div style="font-size:3rem;margin-bottom:10px;">🛒</div>
        <h2>Confirm Purchase</h2>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= sanitize($error) ?></div>
        <?php endif; ?>

        <div class="course-card" style="margin:20px auto;max-width:400px;">
            <h3><?= sanitize($course['title']) ?></h3>
            <p class="course-desc"><?= sanitize($course['description']) ?></p>
            <div class="course-price" style="font-size:1.6rem;">$<?= number_format($course['price'], 2) ?></div>
        </div>

        <p style="color:#9ca3af;margin-bottom:20px;">
            Logged in as <strong style="color:#a5f3fc;"><?= sanitize($_SESSION['user']['email']) ?></strong>
        </p>

        <form method="POST">
            <button type="submit" name="confirm_buy"
                    style="background:linear-gradient(135deg,#00ffff,#6366f1);font-size:16px;">
                Buy for $<?= number_format($course['price'], 2) ?>
            </button>
        </form>

        <br>
        <a href="courses.php" style="color:#9ca3af;">&larr; Cancel</a>
    </div>
</div>

<?php include 'footer.php'; ?>
