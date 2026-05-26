<?php
session_start();
require_once 'helpers.php';

$error = '';

if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    try {
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
        }
        $error = 'Invalid email or password!';
    } catch (Exception $e) {
        $error = 'A server error occurred. Please try again.';
        error_log('Login error: ' . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login – Brain Boost</title>
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
        <p style="color:#9ca3af;margin-bottom:10px;">Login to continue to Brain Boost</p>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= sanitize($error) ?></div>
        <?php endif; ?>

        <?php if (isset($_COOKIE['brain_boost_user'])): ?>
            <p style="color:#a5f3fc;margin-bottom:10px;font-size:14px;">
                Welcome back, <?= sanitize($_COOKIE['brain_boost_user']) ?>!
            </p>
        <?php endif; ?>

        <form method="POST" autocomplete="off">
            <input type="email"    name="email"    placeholder="Email"    required>
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
    glow.style.top  = e.clientY + 'px';
});
</script>
</body>
</html>
