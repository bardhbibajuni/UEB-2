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
    $title       = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price       = floatval($_POST['price'] ?? 0);
    $video_url   = trim($_POST['video_url'] ?? '');
    $instructor  = sanitize($_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname']);

    if (strlen($title) < 3) {
        $error = 'Course title must be at least 3 characters.';
    } elseif (strlen($description) < 10) {
        $error = 'Description must be at least 10 characters.';
    } elseif ($price < 0) {
        $error = 'Price cannot be negative.';
    } else {
        $filePath = '';

        if (!empty($_FILES['course_file']['name'])) {
            $origName  = basename($_FILES['course_file']['name']);
            $ext       = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
            $allowed   = ['pdf', 'mp4', 'mov', 'avi', 'mkv', 'zip'];

            if (!in_array($ext, $allowed)) {
                $error = 'Allowed file types: PDF, MP4, MOV, AVI, MKV, ZIP.';
            } elseif ($_FILES['course_file']['size'] > 200 * 1024 * 1024) {
                $error = 'File too large (max 200 MB).';
            } else {
                $safeName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $origName);
                $dest     = UPLOADS_DIR . '/' . $safeName;
                if (move_uploaded_file($_FILES['course_file']['tmp_name'], $dest)) {
                    $filePath = 'uploads/' . $safeName;
                } else {
                    $error = 'Failed to upload file. Check folder permissions.';
                }
            }
        }

        if (!$error) {
            $courses = getData(DATA_DIR . '/courses.php');
            $courses[] = [
                'id'          => nextId($courses),
                'title'       => sanitize($title),
                'description' => sanitize($description),
                'price'       => $price,
                'instructor'  => $instructor,
                'file'        => $filePath,
                'video_url'   => sanitize($video_url),
                'created_at'  => date('Y-m-d')
            ];
            saveData(DATA_DIR . '/courses.php', $courses);
            $success = 'Course added successfully!';
        }
    }
}

include 'header.php';
?>

<div class="form-wrapper">
    <div class="card wide-card">
        <h2>Add New Course</h2>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success">
                <?= $success ?> <a href="courses.php">View Courses</a>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <label>Course Title</label>
            <input type="text" name="title" placeholder="e.g. PHP Basics" required
                   value="<?= sanitize($_POST['title'] ?? '') ?>">

            <label>Description</label>
            <textarea name="description" placeholder="Describe what students will learn..." rows="4" required><?= sanitize($_POST['description'] ?? '') ?></textarea>

            <label>Price ($)</label>
            <input type="number" name="price" placeholder="e.g. 29.99" step="0.01" min="0"
                   value="<?= sanitize($_POST['price'] ?? '') ?>" required>

            <label>Course File (PDF / Video - max 200MB)</label>
            <input type="file" name="course_file" accept=".pdf,.mp4,.mov,.avi,.mkv,.zip">

            <label>Video URL (YouTube embed link, optional)</label>
            <input type="url" name="video_url" placeholder="https://www.youtube.com/embed/..."
                   value="<?= sanitize($_POST['video_url'] ?? '') ?>">

            <button type="submit">Add Course</button>
        </form>

        <br>
        <a href="courses.php" style="color:#9ca3af;">&larr; Back to Courses</a>
    </div>
</div>

<?php include 'footer.php'; ?>
