<?php
session_start();

$error = "";

if(!isset($_SESSION['users'])){
    $_SESSION['users'] = [];
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = strtolower(trim($_POST['email']));
    $password = trim($_POST['password']);

    $found = false;

    foreach($_SESSION['users'] as $user){
$isEmailMatch = $user['email'] === $email;
$isPasswordMatch = $user['password'] === $password;

if($isEmailMatch && $isPasswordMatch){

            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname']  = $user['lastname'];
            $_SESSION['role']      = $user['role'];
            $_SESSION['email']     = $user['email'];

            
            setcookie("firstname", $user['firstname'], time() + 3600);

            $found = true;

            header("Location: dashboard.php");
            exit();
        }
    }

    if(!$found){
        $error = "Invalid login credentials";
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

<div class="auth-wrapper">
    <div class="card">

    <h2>Welcome Back</h2>
    <p>Login to continue to Brain Boost</p>

    <?php if($error != "") { ?>
        <p style="color:red; margin-bottom:10px;">
            <?php echo $error; ?>
        </p>
    <?php } ?>

    <form method="POST" autocomplete="off">

        <input type="email" name="email" placeholder="Email" required autocomplete="off">
        <input type="password" name="password" placeholder="Password" required autocomplete="off">

        <button type="submit">Login</button>

    </form>

    <br>
    <a href="register.php">Don't have an account? Register</a>

  </div>
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
