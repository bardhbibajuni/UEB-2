<?php
session_start();
include "includes/header.php";
include "../data/data.php";
include "classes/Admin.php";

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != "admin") {
    die("Access denied");
}

$admin = new Admin($users, $courses);

$search = isset($_GET['search']) ? $_GET['search'] : "";

if ($search != "") {
    $courses_to_display = $admin->searchCourses($search);
} else {
    $courses_to_display = $admin->getCourses();
}

setcookie("last_visit", date("H:i:s"), time()+3600);
?>

<div class="dashboard">
    <h1 class="title">Welcome, <?php echo isset($_SESSION['user']) ? $_SESSION['user']['username'] : "Admin"; ?>!</h1>
    <p class="subtitle">Managing: <?php echo count($courses_to_display); ?> Courses</p>

    <!-- SEARCH BOX -->
    <div class="auth-wrapper" style="height: auto; margin-bottom: 50px;">
        <div class="card" style="margin: 0 auto;">
            <form method="GET" action="admin.php">
                <input type="text" name="search" placeholder="Search courses..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">Search</button>
            </form>
        </div>
    </div>

    <!-- COURSES GRID -->
    <div style="display:flex; flex-wrap:wrap; justify-content:center; gap:20px; padding: 20px;">
        <?php
        if (count($courses_to_display) == 0) {
            echo "<p class='subtitle'>No courses found.</p>";
        }

        foreach ($courses_to_display as $course) {
            echo "<div class='card' style='width: 300px;'>";
            echo "<h3>" . htmlspecialchars($course['title']) . "</h3>";
            echo "<a class='logout-btn' style='background: #ff4757;' href='delete_course.php?id=".$course['id']."' onclick=\"return confirm('Delete?')\">Delete</a>";
            echo "</div>";
        }
        ?>
    </div>
</div>

<?php include "includes/footer.php"; ?>
