<?php
session_start();
require_once 'helpers.php';

if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = trim($_POST['password'] ?? '');

    $user = findUser($email);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;

        setcookie('brain_boost_user', $user['firstname'], time() + 3600, '/');

        if ($user['role'] === 'admin') {
            header('Location: admin/admin.php');
        } else {
            header('Location: index.php');
        }
        exit;
    } else {
        $error = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Brain Boost</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="bg"></div>
    <div class="glow" id="glow"></div>

    <nav>
        <div class="logo">Brain Boost</div>
        <div>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        </div>
    </nav>

    <div class="auth-wrapper">
        <div class="card">
            <h2>Welcome Back</h2>
            <p style="color:#9ca3af; margin-bottom:10px;">Login to continue</p>

            <?php if ($error): ?>
                <div class="alert alert-error"><?= $error ?></div>
            <?php endif; ?>

            <?php if (isset($_COOKIE['brain_boost_user'])): ?>
                <p style="color:#a5f3fc;">
                    Welcome back, <?= sanitize($_COOKIE['brain_boost_user']) ?>!
                </p>
            <?php endif; ?>

            <form method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>

            <br>
            <a href="register.php" style="color:#9ca3af;">Don't have an account? Register</a>
        </div>
    </div>

    <script>
        const glow = document.getElementById('glow');
        document.addEventListener('mousemove', e => {
            glow.style.left = e.clientX + 'px';
            glow.style.top = e.clientY + 'px';
        });
    </script>
</body>
</html>