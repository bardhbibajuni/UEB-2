
<?php
session_start();
include "db.php";
/* Kontrollo nese forma e login-it eshte derguar */

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    /*validimi i email me regex */
    if(!preg_match("/^[\w\.-]+@[\w\.-]+\.\w{2,}$/", $email)){
        die("Invalid email format!");
    }

    /* parandalimi i sql injection */
    $email = mysqli_real_escape_string($conn, $email);

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1){

        $user = mysqli_fetch_assoc($result);

        if(password_verify($password, $user['password'])){
$_SESSION['course_type'] = $user['course_type'];
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname'] = $user['lastname'];
            $_SESSION['role'] = $user['role'];

            header("Location: dashboard.php");
            exit();
        }
        else {
            header("Location: login.php?error=wrong_password");
            exit();
        }

    } else {
        header("Location: login.php?error=user_not_found");
        exit();
    }
}
?>
