<?php
include 'includes/header.php';

$courses   = getData(DATA_DIR . '/courses.php');
$purchases = getData(DATA_DIR . '/purchases.php');
?>

<div class="dashboard-wrapper">
    <h1 class="title">Manage Courses</h1>

    <div class="dash-links" style="margin-bottom:30px;">
        <a href="../add_course.php" class="dash-btn">+ Add New Course</a>
    </div>

    <div class="admin-table-wrap">
        <?php if (empty($courses)): ?>
            <p class="subtitle">No courses yet. <a href="../add_course.php">Add one!</a></p>
        <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>File</th>
                    <th>Sales</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($courses as $course): ?>
                <?php $sales = count(array_filter($purchases, fn($p) => $p['course_id'] == $course['id'])); ?>
                <tr>
                    <td>#<?= $course['id'] ?></td>
                    <td><?= sanitize($course['title']) ?></td>
                    <td>$<?= number_format($course['price'], 2) ?></td>
                    <td>
                        <?php if ($course['file']): ?>
                            <span style="color:#4ade80;">&#10003; Uploaded</span>
                        <?php else: ?>
                            <span style="color:#f87171;">No file</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $sales ?></td>
                    <td>
                        <a href="../edit_course.php?id=<?= $course['id'] ?>" class="btn-card btn-edit">Edit</a>
                        <a href="delete_course.php?id=<?= $course['id'] ?>"
                           class="btn-card btn-delete"
                           onclick="return confirm('Delete this course?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
