<?php
session_start();
require_once 'helpers.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = strtolower(trim($_POST['email']));
    $password = $_POST['password'];

    if (!preg_match("/^[a-zA-Z]{2,}$/", $firstname)) {
        $error = "First name must be at least 2 letters";
    } elseif (!preg_match("/^[a-zA-Z]{2,}$/", $lastname)) {
        $error = "Last name must be at least 2 letters";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } elseif (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&._-]).{6,}$/", $password)) {
        $error = "Weak password";
    }

    if ($error === "") {

        $users = getData(DATA_DIR . '/users.php');

        foreach ($users as $u) {
            if ($u['email'] === $email) {
                $error = "User already exists!";
                break;
            }
        }

        if ($error === "") {

            $users[] = [
                "id" => nextId($users),
                "firstname" => $firstname,
                "lastname" => $lastname,
                "email" => $email,
                "password" => password_hash($password, PASSWORD_DEFAULT),
                "role" => "user"
            ];

            saveData(DATA_DIR . '/users.php', $users);

            header("Location: login.php");
            exit;
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

            <h2>Create Account</h2>

            <?php if ($error): ?>
                <div class="alert alert-error"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">

                <input type="text" name="firstname" placeholder="First Name" required>
                <input type="text" name="lastname" placeholder="Last Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>

                <button type="submit">Register</button>

            </form>

            <br>
            <a href="login.php" style="color:#9ca3af;">Already have an account? Login</a>

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