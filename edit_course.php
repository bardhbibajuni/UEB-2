<?php
session_start();
require_once 'helpers.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$id     = intval($_GET['id'] ?? 0);
$course = findCourse($id);

if (!$course) {
    header('Location: courses.php');
    exit;
}

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = trim($_POST['title']       ?? '');
    $description = trim($_POST['description'] ?? '');
    $price       = floatval($_POST['price']   ?? 0);
    $video_url   = trim($_POST['video_url']   ?? '');

    try {
        if (strlen($title) < 3) {
            $error = 'Course title must be at least 3 characters.';
        } elseif (strlen($description) < 10) {
            $error = 'Description must be at least 10 characters.';
        } else {
            $filePath = $course['file_path'];
            $upload   = handleFileUpload('course_file');

            if ($upload['error']) {
                $error = $upload['error'];
            } else {
                if ($upload['path']) {
                    // Delete old file
                    if ($filePath && file_exists(ROOT_DIR . '/' . $filePath)) {
                        @unlink(ROOT_DIR . '/' . $filePath);
                    }
                    $filePath = $upload['path'];
                }

                $ok = updateCourse($id, [
                    'title'       => $title,
                    'description' => $description,
                    'price'       => $price,
                    'video_url'   => $video_url,
                    'file_path'   => $filePath,
                ]);

                if ($ok) {
                    $course  = findCourse($id);
                    $success = 'Course updated successfully!';
                } else {
                    $error = 'Failed to update course.';
                }
            }
        }
    } catch (Exception $e) {
        $error = 'Server error: ' . $e->getMessage();
        error_log('edit_course error: ' . $e->getMessage());
    }
}

include 'header.php';
?>

<div class="form-wrapper">
    <div class="card wide-card">
        <h2>Edit Course</h2>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= sanitize($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= sanitize($success) ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <label>Course Title</label>
            <input type="text" name="title" value="<?= sanitize($course['title']) ?>" required>

            <label>Description</label>
            <textarea name="description" rows="4" required><?= sanitize($course['description']) ?></textarea>

            <label>Price ($)</label>
            <input type="number" name="price" step="0.01" min="0" value="<?= $course['price'] ?>" required>

            <label>Replace Course File (PDF / Video, optional)</label>
            <?php if ($course['file_path']): ?>
                <p style="color:#9ca3af;font-size:13px;">
                    Current: <?= sanitize(basename($course['file_path'])) ?>
                </p>
            <?php endif; ?>
            <input type="file" name="course_file" accept=".pdf,.mp4,.mov,.avi,.mkv,.zip">

            <label>Video URL (optional)</label>
            <input type="url" name="video_url" value="<?= sanitize($course['video_url'] ?? '') ?>"
                   placeholder="https://www.youtube.com/embed/...">

            <button type="submit">Save Changes</button>
        </form>

        <br>
        <a href="courses.php" style="color:#9ca3af;">&larr; Back to Courses</a>
    </div>
</div>

<?php include 'footer.php'; ?>
