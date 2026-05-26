<?php
// AJAX endpoint - check if email is already taken during registration
session_start();
require_once '../helpers.php';

header('Content-Type: application/json');

$email = strtolower(trim($_GET['email'] ?? ''));

if ($email === '' || !validateEmail($email)) {
    echo json_encode(['valid' => false, 'message' => 'Invalid email format']);
    exit;
}

try {
    if (findUser($email)) {
        echo json_encode(['valid' => false, 'message' => 'Email already registered']);
    } else {
        echo json_encode(['valid' => true, 'message' => 'Email is available']);
    }
} catch (Exception $e) {
    error_log('AJAX check_email error: ' . $e->getMessage());
    echo json_encode(['valid' => false, 'message' => 'Server error']);
}
