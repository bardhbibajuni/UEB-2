<?php
// session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Brain Boost</title>

<link rel="stylesheet" href="style.css">

<style>
body {
    font-family: 'Inter', sans-serif;
    margin: 0;
    background: #0b0f19;
    color: white;
}

.bg {
    position: fixed;
    width: 100%;
    height: 100%;
    background:
        radial-gradient(circle at 20% 20%, rgba(99,102,241,0.3), transparent 40%),
        radial-gradient(circle at 80% 30%, rgba(0,255,255,0.2), transparent 40%),
        radial-gradient(circle at 50% 80%, rgba(255,0,255,0.2), transparent 50%);
    filter: blur(90px);
    z-index: -1;
}

nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 40px;
    background: rgba(17,24,39,0.7);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(255,255,255,0.08);
}

nav a {
    color: #9ca3af;
    margin-left: 18px;
    text-decoration: none;
    transition: 0.3s;
}

nav a:hover {
    color: #6366f1;
}

.logo {
    font-weight: bold;
    color: #00ffff;
    text-shadow: 0 0 15px rgba(0,255,255,0.5);
    font-size: 18px;
}

.user {
    color: #f5d0fe;
    margin-right: 15px;
}
</style>
</head>

<body>

<div class="bg"></div>

<nav>
    <div class="logo">🧠 Brain Boost</div>

    <div>

        <a href="index.php">Home</a>

        <?php if(isset($_SESSION['firstname'])) { ?>

            <!-- me shfaq vetem emrin -->
            <span class="user">
                 <?php echo $_SESSION['firstname']; ?>
            </span>

            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php" style="color:#ff4d4d;">Logout</a>

        <?php } else { ?>

            <a href="login.php">Login</a>
            <a href="register.php">Register</a>

        <?php } ?>

    </div>
</nav>
