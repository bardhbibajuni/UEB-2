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
    $lastname  = trim($_POST['lastname'] ?? '');
    $email     = strtolower(trim($_POST['email'] ?? ''));
    $password  = $_POST['password'] ?? '';

    if (!preg_match('/^[a-zA-Z]{2,}$/', $firstname)) {

        $error = 'First name must be at least 2 letters (no numbers or symbols).';

    } elseif (!preg_match('/^[a-zA-Z]{2,}$/', $lastname)) {

        $error = 'Last name must be at least 2 letters (no numbers or symbols).';

    } elseif (!preg_match('/^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/', $email)) {

        $error = 'Invalid email format.';

    } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&._\-]).{6,}$/', $password)) {

        $error = 'Password must be 6+ characters and include a letter, number, and special character.';

    } else {

        if (findUser($email)) {

            $error = 'An account with this email already exists.';

        } else {

            $users   = getData(DATA_DIR . '/users.php');

            $users[] = [
                'id'        => nextId($users),
                'firstname' => sanitize($firstname),
                'lastname'  => sanitize($lastname),
                'email'     => $email,
                'password'  => password_hash($password, PASSWORD_DEFAULT),
                'role'      => 'user'
            ];

            saveData(DATA_DIR . '/users.php', $users);

            $success = 'Registration successful! Redirecting to login...';

            header('Refresh: 2; url=login.php');
        }
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

        <p style="color:#9ca3af; margin-bottom:10px;">
            Join Brain Boost today
        </p>

        <?php if ($error): ?>
            <div class="alert alert-error">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <?= $success ?>
            </div>
        <?php endif; ?>

        <form method="POST" autocomplete="off">

            <input type="text"
                   name="firstname"
                   placeholder="First Name"
                   value="<?= sanitize($_POST['firstname'] ?? '') ?>"
                   required>

            <input type="text"
                   name="lastname"
                   placeholder="Last Name"
                   value="<?= sanitize($_POST['lastname'] ?? '') ?>"
                   required>

            <input type="email"
                   name="email"
                   placeholder="Email"
                   value="<?= sanitize($_POST['email'] ?? '') ?>"
                   required>

            <input type="password"
                   name="password"
                   placeholder="Password (6+, number, special char)"
                   required>

            <button type="submit" name="register">
                Create Account
            </button>

        </form>

        <br>

        <a href="login.php" style="color:#9ca3af;">
            Already have an account? Login
        </a>

    </div>

</div>

</body>
</html>