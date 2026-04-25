<?php
session_start();
include "db.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 1){

        $user = mysqli_fetch_assoc($result);

        if(password_verify($password, $user['password'])){

            $_SESSION['user'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            header("Location: dashboard.php");
            exit();

        } else {
            echo "<script>alert('Wrong password!');</script>";
        }

    } else {
        echo "<script>alert('User not found!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login - Brain Boost</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', sans-serif;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #0b0f19;
    overflow: hidden;
    color: white;
}

/*  BACKGROUND MIST */
.bg {
    position: absolute;
    width: 100%;
    height: 100%;
    background:
        radial-gradient(circle at 20% 20%, rgba(99,102,241,0.3), transparent 40%),
        radial-gradient(circle at 80% 30%, rgba(0,255,255,0.2), transparent 40%),
        radial-gradient(circle at 50% 80%, rgba(255,0,255,0.2), transparent 50%);
    filter: blur(90px);
    z-index: 0;
}

/* GLASS CARD */
.card {
    position: relative;
    z-index: 2;
    width: 380px;
    padding: 35px;
    border-radius: 16px;
    background: rgba(17, 24, 39, 0.85);
    border: 1px solid rgba(255,255,255,0.08);
    backdrop-filter: blur(12px);
    text-align: center;
    box-shadow: 0 10px 40px rgba(0,0,0,0.5);
}

.card h2 {
    font-size: 28px;
    margin-bottom: 10px;
}

.card p {
    color: #9ca3af;
    font-size: 14px;
    margin-bottom: 25px;
}

/* INPUTS */
input {
    width: 100%;
    padding: 14px;
    margin: 10px 0;
    border-radius: 10px;
    border: 1px solid rgba(255,255,255,0.1);
    background: #0f172a;
    color: white;
    outline: none;
    transition: 0.3s;
}

/* Emaili */
input[type="email"] {
    background: rgba(168, 85, 247, 0.12);
    border: 1px solid rgba(192, 132, 252, 0.4);
    color: #f5d0fe;
}

input[type="email"]:focus {
    border-color: #c084fc;
    box-shadow: 0 0 15px rgba(192, 132, 252, 0.5);
}

/* Passwordi*/
input:focus {
    border-color: #6366f1;
    box-shadow: 0 0 10px rgba(99,102,241,0.3);
}

/* Butonat*/
button {
    width: 100%;
    padding: 14px;
    margin-top: 15px;
    border-radius: 10px;
    border: none;
    background: #6366f1;
    color: white;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(99,102,241,0.5);
}

/* linqet */
a {
    display: block;
    margin-top: 15px;
    color: #9ca3af;
    text-decoration: none;
    font-size: 14px;
}

a:hover {
    color: #6366f1;
}

/* te mouse kur bon glow*/
.glow {
    position: absolute;
    width: 250px;
    height: 250px;
    background: radial-gradient(circle, rgba(99,102,241,0.4), transparent 60%);
    border-radius: 50%;
    pointer-events: none;
    transform: translate(-50%, -50%);
    z-index: 1;
}
</style>
</head>

<body>

<div class="bg"></div>
<div class="glow" id="glow"></div>

<div class="card">
    <h2>Welcome Back</h2>
    <p>Login to continue to Brain Boost</p>

    <form method="POST" autocomplete="off">
        <input type="email" name="email" placeholder="Email" required autocomplete="off">
        <input type="password" name="password" placeholder="Password" required autocomplete="new-password">

        <button type="submit">Login</button>
    </form>

    <a href="register.php">Don't have an account? Register</a>
</div>

<script>
const glow = document.getElementById("glow");

document.addEventListener("mousemove", (e) => {
    glow.style.left = e.clientX + "px";
    glow.style.top = e.clientY + "px";
});
</script>

</body>
</html>