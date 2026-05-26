<?php
include 'includes/header.php';
$courses = getAllCourses();
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
                    <th>ID</th><th>Title</th><th>Price</th>
                    <th>File</th><th>Sales</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($courses as $c): ?>
                <tr>
                    <td>#<?= $c['id'] ?></td>
                    <td><?= sanitize($c['title']) ?></td>
                    <td>$<?= number_format($c['price'], 2) ?></td>
                    <td>
                        <?php if ($c['file_path']): ?>
                            <span style="color:#4ade80;">&#10003; Uploaded</span>
                        <?php else: ?>
                            <span style="color:#f87171;">No file</span>
                        <?php endif; ?>
                    </td>
                    <td><?= countPurchasesForCourse($c['id']) ?></td>
                    <td>
                        <a href="../edit_course.php?id=<?= $c['id'] ?>" class="btn-card btn-edit">Edit</a>
                        <a href="#" class="btn-card btn-delete"
                           onclick="ajaxDelete(<?= $c['id'] ?>, this); return false;">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<script>
function ajaxDelete(id, btn) {
    if (!confirm('Delete this course?')) return;
    btn.textContent = '...';
    fetch('../ajax/delete_course.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id=' + id
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            btn.closest('tr').style.opacity = '0';
            setTimeout(() => btn.closest('tr').remove(), 300);
        } else {
            alert(data.message || 'Error'); btn.textContent = 'Delete';
        }
    });
}
</script>

<?php include 'includes/footer.php'; ?>
