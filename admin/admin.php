<?php
session_start();
include "../data/data.php";
include "classes/Admin.php";
include "includes/functions.php";

    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != "admin") {
        die("Access denied");
    }

$admin = new Admin($users, $courses);
$users_count = $admin->countUsers();
$courses_count = $admin->countCourses();

$search = isset($_GET['search']) ? clean($_GET['search']) : "";

if ($search) {
    $courses = $admin->searchCourses($search);
} else {
    $courses = $admin->getCourses();
}

setcookie("last_visit", date("Y-m-d H:i:s"), time() + 3600);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #f4f6f9;
        }
        .sidebar {
            width: 220px;
            height: 100vh;
            background: #1e293b;
            color: white;
            position: fixed;
            padding: 20px;
        }
        .sidebar h2 {
            margin-bottom: 30px;
        }
        .sidebar a {
            display: block;
            color: #cbd5e1;
            text-decoration: none;
            margin: 10px 0;
        }
        .sidebar a:hover {
            color: white;
        }
        .main {
            margin-left: 240px;
            padding: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        input {
            padding: 8px;
            width: 250px;
        }
        button {
            padding: 8px 12px;
            background: #2563eb;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background: #1d4ed8;
        }
        .danger {
            color: red;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Admin</h2>
    <a href="admin.php">Dashboard</a>
    <a href="users.php">Users</a>
    <a href="courses.php">Courses</a>
</div>

<div class="main">

  <div class="card">
        <h3>Statistics</h3>
        <p>Total Users: <?php echo $users_count; ?></p>
        <p>Total Courses: <?php echo $courses_count; ?></p>
    </div>


    <div class="card">
        <h3>Last Visit</h3>
        <?php
        if (isset($_COOKIE['last_visit'])) {
            echo $_COOKIE['last_visit'];
        } else {
            echo "First time here";
        }
        ?>
    </div>


    <div class="card">
        <h2>Search Courses</h2>
        <form method="GET">
            <input type="text" name="search" placeholder="Search..." />
            <button>Search</button>
        </form>
    </div>

    <div class="card">
        <h2>Courses</h2>

        <?php
foreach ($courses as $course) {
    echo $course['title'];
    echo " <a href='delete_course.php?id=".$course['id']."' onclick=\"return confirm('Delete?')\">Delete</a><br>";
}
?>

    </div>

</div>

</body>
</html>