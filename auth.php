<?php
session_start();
include "db.php";

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    /* REGEX EMAIL */
    if(!preg_match("/^[\w\.-]+@[\w\.-]+\.\w{2,}$/", $email)){
        die("Invalid email format!");
    }

    /* prevent SQL injection */
    $email = mysqli_real_escape_string($conn, $email);

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1){

        $user = mysqli_fetch_assoc($result);

        if(password_verify($password, $user['password'])){

            /* 🔥 SESSION (IMPORTANT FIX) */
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname'] = $user['lastname'];
            $_SESSION['role'] = $user['role'];

            header("Location: dashboard.php");
            exit();

        } else {
            header("Location: login.php?error=wrong_password");
            exit();
        }

    } else {
        header("Location: login.php?error=user_not_found");
        exit();
    }
}
?>