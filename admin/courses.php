<?php
session_start();
include "../db.php";

if ($_SESSION['is_admin'] != 1) {
    die("Access denied");
}

$result = mysqli_query($conn, "SELECT * FROM courses");
?>

<h2>Courses</h2>

<?php
while ($course = mysqli_fetch_assoc($result)) {
    echo htmlspecialchars($course['title']);
    echo " <a href='delete_course.php?id=" . $course['id'] . "' style='color:red'>Delete</a><br>";
}
?>