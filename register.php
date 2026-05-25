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
