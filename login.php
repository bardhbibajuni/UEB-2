<?php
session_start();
require_once 'helpers.php';

$error = '';

if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email    = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    $user = findUser($email);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        setcookie('brain_boost_user', $user['firstname'], time() + 3600, '/');

        if ($user['role'] === 'admin') {
            header('Location: admin/admin.php');
        } else {
            header('Location: index.php');
        }
        exit;
    }

    $error = 'Invalid email or password!';
}
?>
