<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

if(isset($_POST['register'])){

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // regexi per email
    if(!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)){
        die("Invalid email format");
    }

    //validim per password (minimum 6 characters)
    if(strlen($password) < 6){
        die("Password must be at least 6 characters");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    //  kontrollojme nese useri ekziston me kete email
    $check = "SELECT * FROM users WHERE email='$email'";
    $res = mysqli_query($conn, $check);

    if(mysqli_num_rows($res) > 0){
        die("User already exists!");
    }

    //  nese nuk ekziston, e insertojme ne database
    $sql = "INSERT INTO users (email, password, role)
            VALUES ('$email', '$hashedPassword', 'user')";

    if(mysqli_query($conn, $sql)){
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register - Brain Boost</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Inter', sans-serif;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #0b0f19;
    color: white;
    overflow: hidden;
}

.bg {
    position: absolute;
    width: 100%;
    height: 100%;
    background:
        radial-gradient(circle at 20% 20%, rgba(99,102,241,0.3), transparent 40%),
        radial-gradient(circle at 80% 30%, rgba(0,255,255,0.2), transparent 40%),
        radial-gradient(circle at 50% 80%, rgba(255,0,255,0.2), transparent 50%);
    filter: blur(90px);
}

.card {
    position: relative;
    width: 380px;
    padding: 35px;
    border-radius: 16px;
    background: rgba(17, 24, 39, 0.85);
    backdrop-filter: blur(12px);
    text-align: center;
}

input {
    width: 100%;
    padding: 14px;
    margin: 10px 0;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.08);
    background: rgba(15, 23, 42, 0.8);
    color: white;
    outline: none;
    transition: 0.3s;
}

input::placeholder {
    color: rgba(255,255,255,0.4);
}

/* input[type="email"] {
    background: rgba(168, 85, 247, 0.12);
    color: #f5d0fe;
    border: 1px solid rgba(192, 132, 252, 0.4);
} */

button {
    width: 100%;
    padding: 14px;
    margin-top: 15px;
    border-radius: 10px;
    border: none;
    background: #6366f1;
    color: white;
    font-weight: bold;
    cursor: pointer;
}

button:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(99,102,241,0.4);
}
</style>

</head>

<body>

<div class="bg"></div>

<div class="card">
    <h2>Create Account</h2>

   <form method="POST" action="auth.php" autocomplete="off">
<!-- me blloku autofill-in  -->
<input type="text" style="display:none" autocomplete="off">
<input type="password" style="display:none" autocomplete="off">

<input type="text" name="firstname" placeholder="First Name" required>
<input type="text" name="lastname" placeholder="Last Name" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<button type="submit" name="register">Register</button>

</form>

</div>
<div id="toast" style="
position: fixed;
top: 20px;
right: 20px;
background: #22c55e;
color: white;
padding: 12px 18px;
border-radius: 10px;
display:none;
">
✔ Registration successful
</div>
<script>
function showToast(){
    document.getElementById('toast').style.display = 'block';
    setTimeout(() => {
        window.location.href = "login.php";
    }, 2000);
}
</script>
</body>
</html>
