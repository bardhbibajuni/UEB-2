<?php
session_start();
require_once 'helpers.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = trim($_POST['title']       ?? '');
    $description = trim($_POST['description'] ?? '');
    $price       = floatval($_POST['price']   ?? 0);
    $video_url   = trim($_POST['video_url']   ?? '');
    $instructor  = $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'];

    try {
        if (strlen($title) < 3) {
            $error = 'Course title must be at least 3 characters.';
        } elseif (strlen($description) < 10) {
            $error = 'Description must be at least 10 characters.';
        } elseif ($price < 0) {
            $error = 'Price cannot be negative.';
        } else {
            $upload = handleFileUpload('course_file');

            if ($upload['error']) {
                $error = $upload['error'];
            } else {
                $ok = createCourse([
                    'title'       => $title,
                    'description' => $description,
                    'price'       => $price,
                    'instructor'  => $instructor,
                    'file_path'   => $upload['path'],
                    'video_url'   => $video_url,
                ]);

                if ($ok) {
                    $success = 'Course added successfully!';
                } else {
                    $error = 'Failed to save course. Please try again.';
                }
            }
        }
    } catch (Exception $e) {
        $error = 'Server error: ' . $e->getMessage();
        error_log('add_course error: ' . $e->getMessage());
    }
}

include 'header.php';
?>

<div class="form-wrapper">
    <div class="card wide-card">
        <h2>Add New Course</h2>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= sanitize($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success">
                <?= sanitize($success) ?> <a href="courses.php">View Courses</a>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <label>Course Title</label>
            <input type="text" name="title" placeholder="e.g. PHP Basics" required
                   value="<?= sanitize($_POST['title'] ?? '') ?>">

            <label>Description</label>
            <textarea name="description" rows="4" required><?= sanitize($_POST['description'] ?? '') ?></textarea>

            <label>Price ($)</label>
            <input type="number" name="price" placeholder="e.g. 29.99" step="0.01" min="0"
                   value="<?= sanitize($_POST['price'] ?? '') ?>" required>

            <label>Course File (PDF / Video – max 200 MB)</label>
            <input type="file" name="course_file" accept=".pdf,.mp4,.mov,.avi,.mkv,.zip">

            <label>Video URL (YouTube embed, optional)</label>
            <input type="url" name="video_url" placeholder="https://www.youtube.com/embed/..."
                   value="<?= sanitize($_POST['video_url'] ?? '') ?>">

            <button type="submit">Add Course</button>
        </form>

        <br>
        <a href="courses.php" style="color:#9ca3af;">&larr; Back to Courses</a>
    </div>
</div>

<?php include 'footer.php'; ?>
