<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Brain Boost</title>

<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="bg"></div>

<nav>
    <div class="logo">Brain Boost</div>

    <div>
        <a href="index.php">Home</a>

        <?php if(isset($_SESSION['firstname'])) { ?>

           
            <a href="dashboard.php">Dashboard</a>
           <a href="logout.php" class="logout-btn">Logout</a>

        <?php } else { ?>

            <a href="login.php">Login</a>
            <a href="register.php">Register</a>

        <?php } ?>
    </div>
</nav>
