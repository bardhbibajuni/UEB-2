<?php
// AJAX endpoint - toggle user role between admin and user (admin only)
session_start();
require_once '../helpers.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$id = intval($_POST['id'] ?? 0);

if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid user ID']);
    exit;
}

if ($id === (int)$_SESSION['user']['id']) {
    echo json_encode(['success' => false, 'message' => 'You cannot change your own role']);
    exit;
}

try {
    $user = findUserById($id);
    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'User not found']);
        exit;
    }

    $newRole = $user['role'] === 'admin' ? 'user' : 'admin';

    $db   = getDB();
    $stmt = $db->prepare('UPDATE users SET role = ? WHERE id = ?');
    $stmt->execute([$newRole, $id]);

    echo json_encode(['success' => true, 'role' => $newRole]);
} catch (Exception $e) {
    error_log('AJAX toggle_user_role error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Server error']);
}
