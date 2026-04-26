<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

$error = '';

if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

if (!isset($_SESSION['users']) || !is_array($_SESSION['users'])) {
    $_SESSION['users'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    $foundUser = null;

    foreach ($_SESSION['users'] as $u) {
        if (!empty($u['email']) && $u['email'] === $email) {
            $foundUser = $u;
            break;
        }
    }

    if ($foundUser && password_verify($password, $foundUser['password'])) {

        $_SESSION['user'] = $foundUser;

        header("Location: index.php");
        exit;
    }

    $error = "Invalid email or password!";
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

        <p style="color:#9ca3af; margin-bottom:10px;">
            Login to continue to Brain Boost
        </p>

        <?php if ($error): ?>
            <div class="alert alert-error">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" autocomplete="off">

            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit">Login</button>

        </form>

        <br>
        <a href="register.php" style="color:#9ca3af;">
            Don't have an account? Register
        </a>

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
