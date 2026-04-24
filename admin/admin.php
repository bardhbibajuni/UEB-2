<?php
session_start();
include "../db.php";

// if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
//     die("Access denied");
// }
// ?>
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
        <h2>Search Courses</h2>
        <form method="GET">
            <input type="text" name="search" placeholder="Search..." />
            <button>Search</button>
        </form>
    </div>

    <div class="card">
        <h2>Courses</h2>

        <?php
        $search = isset($_GET['search']) 
            ? mysqli_real_escape_string($conn, $_GET['search']) 
            : "";

        $sql = "SELECT * FROM courses WHERE title LIKE '%$search%'";
        $result = mysqli_query($conn, $sql);

        while ($course = mysqli_fetch_assoc($result)) {
            echo "<p>" . htmlspecialchars($course['title']) . 
                 " <a class='danger' href='delete_course.php?id=" . $course['id'] . "'>Delete</a></p>";
        }
        ?>
    </div>

</div>

</body>
</html>