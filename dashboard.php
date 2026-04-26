<?php
session_start();
/* Kontrollo nese perdoruesi eshte kyçur, nese jo e ridrejton ne login */
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}
?>
<?php include "header.php"; ?>

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
/* Glow efekti */
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

/* Containeri */
.dashboard {
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

/* Logout butoni */
.logout-btn {
    padding: 14px 30px;
    border-radius: 30px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    color: white;
    background: linear-gradient(135deg, #ff00ff, #6366f1);
    transition: 0.3s;
}

.logout-btn:hover {
    transform: translateY(-5px) scale(1.05);
    box-shadow: 0 10px 30px rgba(255,0,255,0.5);
}
</style>
require_once 'helpers.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
$allCourses = getData(DATA_DIR . '/courses.php');
$purchases  = getData(DATA_DIR . '/purchases.php');
$myCount = count(array_filter($purchases, fn($p) => $p['user_id'] == $user['id']));

include 'header.php';
?>

<div class="dashboard-wrapper">
    <div class="glow" id="glow"></div>

    <h1 class="title">
    Welcome, <?php echo "{$_SESSION['firstname']} {$_SESSION['lastname']}!"; ?>
</h1>
    
  <p class="subtitle">
    Welcome to your Brain Boost dashboard.
</p>
        Welcome, <?= sanitize($user['firstname']) . ' ' . sanitize($user['lastname']) ?>!
    </h1>
    <p class="subtitle">
        <?php if (isset($_COOKIE['brain_boost_user'])): ?>
            Good to see you again, <?= sanitize($_COOKIE['brain_boost_user']) ?>!
        <?php else: ?>
            Your Brain Boost Dashboard
        <?php endif; ?>
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
            <div class="stat-number"><?= ucfirst($user['role']) ?></div>
            <div class="stat-label">Role</div>
        </div>
    </div>

    <div class="dash-links">
        <a href="courses.php" class="dash-btn">Browse Courses</a>
        <a href="my_courses.php" class="dash-btn">My Courses</a>
        <?php if ($user['role'] === 'admin'): ?>
            <a href="add_course.php" class="dash-btn">Add Course</a>
            <a href="admin/admin.php" class="dash-btn dash-btn-admin">Admin Panel</a>
        <?php endif; ?>
    </div>
</div>



<script>
const glow = document.getElementById("glow");
/* Levizja e efektit me maus */
document.addEventListener("mousemove", (e) => {
    glow.style.left = e.clientX + "px";
    glow.style.top = e.clientY + "px";
});
</script>

<?php include "footer.php"; ?>
<?php include 'footer.php'; ?>
