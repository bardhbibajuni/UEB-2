<?php
// Reusable courses grid – used by courses.php and ajax/search_courses.php
// $courses must be defined before including this file.
if (!isset($courses)) $courses = [];
?>
<?php if (empty($courses)): ?>
    <p class="subtitle" style="text-align:center;margin-top:40px;">No courses found.</p>
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
            <?php $purchased = hasPurchased((int)$_SESSION['user']['id'], (int)$course['id']); ?>
            <div style="display:flex;gap:8px;flex-wrap:wrap;justify-content:center;">
                <?php if ($purchased): ?>
                    <a href="course_view.php?id=<?= $course['id'] ?>" class="btn-card btn-view">Open Course</a>
                <?php else: ?>
                    <a href="buy_course.php?id=<?= $course['id'] ?>" class="btn-card btn-buy">
                        Buy – $<?= number_format($course['price'], 2) ?>
                    </a>
                <?php endif; ?>

                <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                    <a href="edit_course.php?id=<?= $course['id'] ?>" class="btn-card btn-edit">Edit</a>
                    <a href="#" class="btn-card btn-delete"
                       onclick="deleteCourse(<?= $course['id'] ?>, this); return false;">Delete</a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <a href="login.php" class="btn-card btn-buy">Login to Buy</a>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>

<script>
// AJAX delete course (admin only)
function deleteCourse(id, btn) {
    if (!confirm('Delete this course and all its purchases?')) return;
    btn.textContent = '...';
    fetch('ajax/delete_course.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id=' + id + '&csrf=' + encodeURIComponent(document.cookie.match(/PHPSESSID=([^;]+)/)?.[1] || '')
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            btn.closest('.course-card').style.transition = 'opacity 0.3s';
            btn.closest('.course-card').style.opacity = '0';
            setTimeout(() => btn.closest('.course-card').remove(), 300);
        } else {
            alert(data.message || 'Error deleting course.');
            btn.textContent = 'Delete';
        }
    })
    .catch(() => { btn.textContent = 'Delete'; });
}
</script>
