<?php
session_start();
require_once 'helpers.php';

if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$error   = '';
$success = '';

if (isset($_POST['register'])) {
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname  = trim($_POST['lastname']  ?? '');
    $email     = strtolower(trim($_POST['email'] ?? ''));
    $password  = $_POST['password'] ?? '';

    try {
        if (!validateName($firstname)) {
            $error = 'First name must be at least 2 letters (no numbers or symbols).';
        } elseif (!validateName($lastname)) {
            $error = 'Last name must be at least 2 letters (no numbers or symbols).';
        } elseif (!validateEmail($email)) {
            $error = 'Invalid email format.';
        } elseif (!validatePassword($password)) {
            $error = 'Password must be 6+ characters and include a letter, number, and special character.';
        } elseif (findUser($email)) {
            $error = 'An account with this email already exists.';
        } else {
            if (createUser($firstname, $lastname, $email, $password)) {
                $success = 'Registration successful! Redirecting to login...';
                header('Refresh: 2; url=login.php');
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
    } catch (Exception $e) {
        $error = 'A server error occurred. Please try again.';
        error_log('Register error: ' . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Brain Boost</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="bg"></div>

<nav>
    <div class="logo">Brain Boost</div>
    <div>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    </div>
</nav>

<div class="auth-wrapper">
    <div class="card">
        <h2>Create Account</h2>
        <p style="color:#9ca3af;margin-bottom:10px;">Join Brain Boost today</p>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= sanitize($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= sanitize($success) ?></div>
        <?php endif; ?>

        <form method="POST" autocomplete="off">
            <input type="text"  name="firstname" placeholder="First Name"
                   value="<?= sanitize($_POST['firstname'] ?? '') ?>" required>
            <input type="text"  name="lastname"  placeholder="Last Name"
                   value="<?= sanitize($_POST['lastname']  ?? '') ?>" required>
            <input type="email" name="email" id="emailField"  placeholder="Email"
                   value="<?= sanitize($_POST['email']     ?? '') ?>" required>
            <small id="emailStatus" style="display:block;margin:-8px 0 8px 4px;font-size:12px;min-height:14px;"></small>
            <input type="password" name="password"
                   placeholder="Password (6+, letter, number, special char)" required>
            <button type="submit" name="register">Create Account</button>
        </form>

        <br>
        <a href="login.php" style="color:#9ca3af;">Already have an account? Login</a>
    </div>
</div>

<script>
let emailTimer;
const emailField  = document.getElementById('emailField');
const emailStatus = document.getElementById('emailStatus');

emailField.addEventListener('input', function () {
    clearTimeout(emailTimer);
    const val = this.value.trim();
    if (val.length < 4) { emailStatus.textContent = ''; return; }

    emailTimer = setTimeout(() => {
        fetch('ajax/check_email.php?email=' + encodeURIComponent(val))
            .then(r => r.json())
            .then(data => {
                emailStatus.textContent = data.message || '';
                emailStatus.style.color = data.valid ? '#4ade80' : '#f87171';
            })
            .catch(() => { emailStatus.textContent = ''; });
    }, 400);
});
</script>
</body>
</html>
