<?php
session_start();
include "db.php";

if ($_SESSION['is_admin'] != 1) {
    die("Access denied");
}

$result = mysqli_query($conn, "SELECT * FROM users");
?>

<h2>Users</h2>

<?php
while ($user = mysqli_fetch_assoc($result)) {
    echo htmlspecialchars($user['username']) . " - " . htmlspecialchars($user['email']);
    echo " <a href='delete_user.php?id=" . $user['id'] . "' style='color:red'>Delete</a><br>";
}
?>