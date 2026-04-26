<?php
session_start();
require_once 'helpers.php';

/* Kontrollo login */
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];

/* siguri për courses & purchases */
$allCourses = getData(DATA_DIR . '/courses.php') ?? [];
$purchases  = getData(DATA_DIR . '/purchases.php') ?? [];

/* fallback ID (sepse ti s’ke id në register) */
$userId = $user['id'] ?? $user['email'] ?? null;

/* llogarit kursat e blera */
$myCount = 0;

if ($userId) {
    $myCount = count(array_filter($purchases, function ($p) use ($userId) {
        return isset($p['user_id']) && $p['user_id'] == $userId;
    }));
}

include "header.php";
?>

<style>
.bg {
    position: fixed;
    width: 100%;
    height: 100%;
    background:
        radial-gradient(circle at 20% 20%, rgba(99,102,241,0.3), transparent 40%),
        radial-gradient(circle at 80% 30%, rgba(0,255,255,0.2), transparent 40%),
        radial-gradient(circle at 50% 80%, rgba(255,0,255,0.2), transparent 50%);
    filter: blur(100px);
    z-index: -1;
}

.glow {
    position: fixed;
    width: 250px;
    height: 250px;
    background: radial-gradient(circle, rgba(99,102,241,0.4), transparent 60%);
    border-radius: 50%;
    pointer-events: none;
    transform: translate(-50%, -50%);
    z-index: 0;
}

.dashboard-wrapper {
    text-align: center;
    padding: 100px 20px;
    color: white;
}

.title {
    font-size: 3rem;
    font-weight: 700;
    background: linear-gradient(90deg, #00ffff, #6366f1, #ff00ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 10px;
}

.subtitle {
    color: #9ca3af;
    margin-bottom: 30px;
}

.dash-links {
    margin-top: 30px;
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.dash-btn {
    padding: 12px 25px;
    border-radius: 25px;
    text-decoration: none;
    color: white;
    background: linear-gradient(135deg, #6366f1, #00ffff);
    transition: 0.3s;
}

.dash-btn:hover {
    transform: translateY(-3px);
}
</style>

<div class="dashboard-wrapper">
    <div class="glow" id="glow"></div>

    <h1 class="title">
        Welcome, <?= sanitize($user['firstname'] ?? '') . ' ' . sanitize($user['lastname'] ?? '') ?>!
    </h1>

    <p class="subtitle">
        Welcome to your Brain Boost dashboard.
    </p>

    <div class="stats-row">

        <div class="stat-card">
            <div class="stat-number"><?= count($allCourses) ?></div>
            <div class="stat-label">Courses Available</div>
        </div>

        <div class="stat-card">
            <div class="stat-number"><?= $myCount ?></div>
            <div class="stat-label">My Courses</div>
        </div>

        <div class="stat-card">
            <div class="stat-number"><?= ucfirst($user['role'] ?? 'user') ?></div>
            <div class="stat-label">Role</div>
        </div>

    </div>

    <div class="dash-links">
        <a href="courses.php" class="dash-btn">Browse Courses</a>
        <a href="my_courses.php" class="dash-btn">My Courses</a>

        <?php if (($user['role'] ?? '') === 'admin'): ?>
            <a href="add_course.php" class="dash-btn">Add Course</a>
            <a href="admin/admin.php" class="dash-btn">Admin Panel</a>
        <?php endif; ?>
    </div>
</div>

<script>
const glow = document.getElementById("glow");

document.addEventListener("mousemove", (e) => {
    glow.style.left = e.clientX + "px";
    glow.style.top = e.clientY + "px";
});
</script>

<?php include "footer.php"; ?>
