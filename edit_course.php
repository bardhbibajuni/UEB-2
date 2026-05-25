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
    $title       = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price       = floatval($_POST['price'] ?? 0);
    $video_url   = trim($_POST['video_url'] ?? '');

    if (strlen($title) < 3) {
        $error = 'Course title must be at least 3 characters.';
    } elseif (strlen($description) < 10) {
        $error = 'Description must be at least 10 characters.';
    } else {
        $filePath = $course['file'];

        if (!empty($_FILES['course_file']['name'])) {
            $origName = basename($_FILES['course_file']['name']);
            $ext      = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
            $allowed  = ['pdf', 'mp4', 'mov', 'avi', 'mkv', 'zip'];

            if (!in_array($ext, $allowed)) {
                $error = 'Allowed file types: PDF, MP4, MOV, AVI, MKV, ZIP.';
            } elseif ($_FILES['course_file']['size'] > 200 * 1024 * 1024) {
                $error = 'File too large (max 200 MB).';
            } else {
                $safeName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $origName);
                $dest     = UPLOADS_DIR . '/' . $safeName;

                if (move_uploaded_file($_FILES['course_file']['tmp_name'], $dest)) {

                    // Delete old file if exists
                    if ($filePath && file_exists(ROOT_DIR . '/' . $filePath)) {
                        @unlink(ROOT_DIR . '/' . $filePath);
                    }

                    $filePath = 'uploads/' . $safeName;

                } else {
                    $error = 'Failed to upload file.';
                }
            }
        }

        if (!$error) {
            $courses = getData(DATA_DIR . '/courses.php');

            foreach ($courses as &$c) {
                if ($c['id'] == $id) {
                    $c['title']       = sanitize($title);
                    $c['description'] = sanitize($description);
                    $c['price']       = $price;
                    $c['file']        = $filePath;
                    $c['video_url']   = sanitize($video_url);
                    break;
                }
            }

            saveData(DATA_DIR . '/courses.php', $courses);

            $course  = findCourse($id);
            $success = 'Course updated successfully!';
        }
    }
}

include 'header.php';
?>

<div class="form-wrapper">
    <div class="card wide-card">

        <h2>Edit Course</h2>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">

            <label>Course Title</label>
            <input type="text"
                   name="title"
                   value="<?= sanitize($course['title']) ?>"
                   required>

            <label>Description</label>
            <textarea name="description"
                      rows="4"
                      required><?= sanitize($course['description']) ?></textarea>

            <label>Price ($)</label>
            <input type="number"
                   name="price"
                   step="0.01"
                   min="0"
                   value="<?= $course['price'] ?>"
                   required>

            <label>Replace Course File (PDF / Video, optional)</label>

            <?php if ($course['file']): ?>
                <p style="color:#9ca3af; font-size:13px;">
                    Current: <?= sanitize(basename($course['file'])) ?>
                </p>
            <?php endif; ?>

            <input type="file"
                   name="course_file"
                   accept=".pdf,.mp4,.mov,.avi,.mkv,.zip">

            <label>Video URL (optional)</label>

            <input type="url"
                   name="video_url"
                   value="<?= sanitize($course['video_url']) ?>"
                   placeholder="https://www.youtube.com/embed/...">

            <button type="submit">Save Changes</button>

        </form>

        <br>

        <a href="courses.php" style="color:#9ca3af;">
            &larr; Back to Courses
        </a>

    </div>
</div>

<?php include 'footer.php'; ?>