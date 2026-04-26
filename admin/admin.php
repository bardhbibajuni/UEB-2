<?php
include 'includes/header.php';

$users     = getData(DATA_DIR . '/users.php');
$courses   = getData(DATA_DIR . '/courses.php');
$purchases = getData(DATA_DIR . '/purchases.php');

$search = trim($_GET['search'] ?? '');
$displayCourses = $search
    ? array_filter($courses, fn($c) => stripos($c['title'], $search) !== false)
    : $courses;

setcookie('last_admin_visit', date('Y-m-d H:i:s'), time() + 3600, '/');
?>

<div class="dashboard-wrapper">
    <h1 class="title">Admin Dashboard</h1>
    <p class="subtitle">
        Welcome, <?= sanitize($_SESSION['user']['firstname']) ?>!
        <?php if (isset($_COOKIE['last_admin_visit'])): ?>
            &nbsp;&bull;&nbsp; Last visit: <?= sanitize($_COOKIE['last_admin_visit']) ?>
        <?php endif; ?>
    </p>

    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-number"><?= count($users) ?></div>
            <div class="stat-label">Total Users</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= count($courses) ?></div>
            <div class="stat-label">Courses</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= count($purchases) ?></div>
            <div class="stat-label">Purchases</div>
        </div>
    </div>

    <div class="dash-links" style="margin-bottom:40px;">
        <a href="../add_course.php" class="dash-btn">+ Add Course</a>
        <a href="users.php" class="dash-btn">Manage Users</a>
        <a href="courses.php" class="dash-btn">Manage Courses</a>
    </div>

    <h2 style="color:#fff; margin-bottom:20px;">Course Search</h2>
    <form method="GET" class="search-form" style="max-width:500px; margin:0 auto 30px;">
        <input type="text" name="search" placeholder="Search courses..." value="<?= sanitize($search) ?>">
        <button type="submit">Search</button>
        <?php if ($search): ?>
            <a href="admin.php" style="color:#9ca3af; margin-left:10px;">Clear</a>
        <?php endif; ?>
    </form>

    <div class="admin-table-wrap">
        <?php if (empty($displayCourses)): ?>
            <p class="subtitle">No courses found.</p>
        <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Instructor</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($displayCourses as $course): ?>
                <tr>
                    <td>#<?= $course['id'] ?></td>
                    <td><?= sanitize($course['title']) ?></td>
                    <td>$<?= number_format($course['price'], 2) ?></td>
                    <td><?= sanitize($course['instructor']) ?></td>
                    <td><?= sanitize($course['created_at']) ?></td>
                    <td>
                        <a href="../edit_course.php?id=<?= $course['id'] ?>" class="btn-card btn-edit">Edit</a>
                        <a href="../delete_course.php?id=<?= $course['id'] ?>"
                           class="btn-card btn-delete"
                           onclick="return confirm('Delete this course and all its purchases?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
