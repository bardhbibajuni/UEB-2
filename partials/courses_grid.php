<?php

if (!isset($courses) || !is_array($courses)) {
    $courses = [];
}
?>

<?php if (empty($courses)): ?>
    <p class="subtitle" style="text-align:center;margin-top:40px;">
        No courses found.
    </p>
<?php else: ?>
    <div class="courses-grid">

        <?php foreach ($courses as $course): ?>
            <div class="course-card">
                <div class="course-icon">📚</div>

                <h3><?= sanitize($course['title'] ?? '') ?></h3>

                <p class="course-desc">
                    <?= sanitize($course['description'] ?? '') ?>
                </p>

                <div class="course-meta">
                    <span class="course-price">
                        $<?= number_format((float)($course['price'] ?? 0), 2) ?>
                    </span>

                    <span class="course-instructor">
                        by <?= sanitize($course['instructor'] ?? '') ?>
                    </span>
                </div>

                <?php if (!empty($_SESSION['user'])): ?>

                    <?php
                        $userId = (int)$_SESSION['user']['id'];
                        $courseId = (int)$course['id'];
                        $purchased = function_exists('hasPurchased')
                            ? hasPurchased($userId, $courseId)
                            : false;
                    ?>

                    <div style="display:flex;gap:8px;flex-wrap:wrap;justify-content:center;">

                        <?php if ($purchased): ?>
                            <a href="course_view.php?id=<?= $courseId ?>" class="btn-card btn-view">
                                Open Course
                            </a>
                        <?php else: ?>
                            <a href="buy_course.php?id=<?= $courseId ?>" class="btn-card btn-buy">
                                Buy - $<?= number_format((float)($course['price'] ?? 0), 2) ?>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
                            <a href="edit_course.php?id=<?= $courseId ?>" class="btn-card btn-edit">
                                Edit
                            </a>

                            <a href="#" class="btn-card btn-delete"
                               onclick="deleteCourse(<?= $courseId ?>, this); return false;">
                                Delete
                            </a>
                        <?php endif; ?>

                    </div>

                <?php else: ?>
                    <a href="login.php" class="btn-card btn-buy">
                        Login to Buy
                    </a>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>

    </div>
<?php endif; ?>

<script>

function deleteCourse(id, btn) {
    if (!confirm('Delete this course and all its purchases?')) return;

    btn.textContent = '...';

    fetch('ajax/delete_course.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id=' + encodeURIComponent(id)
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const card = btn.closest('.course-card');
            card.style.transition = 'opacity 0.3s';
            card.style.opacity = '0';

            setTimeout(() => card.remove(), 300);
        } else {
            alert(data.message || 'Error deleting course.');
            btn.textContent = 'Delete';
        }
    })
    .catch(() => {
        btn.textContent = 'Delete';
    });
}
</script>