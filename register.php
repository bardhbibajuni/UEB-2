<?php
session_start();

$error = "";
if(!isset($_SESSION['users'])){
    $_SESSION['users'] = [];
}

if(isset($_POST['register'])){

    $firstname = trim($_POST['firstname']);
    $lastname  = trim($_POST['lastname']);
    $email     = strtolower(trim($_POST['email']));
    $password  = $_POST['password'];
    $category = $_POST['category'];

    if(!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)){
        $error = "Invalid email format";
    }

    
    if(!preg_match("/^[a-zA-Z]{2,}$/", $firstname)){
        $error = "First name must be at least 2 letters";
    }

    
    if(!preg_match("/^[a-zA-Z]{2,}$/", $lastname)){
        $error = "Last name must be at least 2 letters";
    }


    if(!preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&._-]).{6,}$/", $password)){
        $error = "Password must contain letter, number, special char and be 6+ characters";
    }


    if($error != ""){
        echo "<script>alert('$error');</script>";
    } else {

        
        foreach($_SESSION['users'] as $u){
            if($u['email'] === $email){
                $error = "User already exists!";
                echo "<script>alert('$error');</script>";
                exit();
            }
        }

       
        $_SESSION['users'][] = [
            "email" => $email,
            "password" => $password,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "category" => $category,
            "role" => "user"
        
        ];

        echo "<script>
            alert('Registration successful!');
            window.location.href='login.php';
        </script>";
        exit();
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

<div class="auth-wrapper">
    <div class="card">

    <h2>Create Account</h2>

    <form method="POST">

        <input type="text" name="firstname" placeholder="First Name" required>
        <input type="text" name="lastname" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
<select name="category" required>
    <option value="">Select Course Category</option>
    <option value="programming">Programming</option>
    <option value="design">Design</option>
    <option value="math">Mathematics</option>
    <option value="science">Science</option>
</select>
        <button type="submit" name="register">Register</button>

    </form>

    </div>
</div>

</body>
</html>
