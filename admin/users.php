<?php
session_start();
include "data/data.php";
include "classes/Admin.php";

if ($_SESSION['user']['role'] != "admin") {
    die("Access denied");
}

$admin = new Admin($users, $courses);
$users = $admin->getUsers();

echo "<h2>Users</h2>";

foreach ($users as $user) {
    echo $user['username'];
    echo " <a href='delete_user.php?id=".$user['id']."'>Delete</a><br>";
}