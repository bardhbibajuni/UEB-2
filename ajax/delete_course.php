<?php
// AJAX endpoint - delete course (admin only)
session_start();
require_once '../helpers.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$id = intval($_POST['id'] ?? 0);

if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid course ID']);
    exit;
}

try {
    if (deleteCourse($id)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Could not delete course']);
    }
} catch (Exception $e) {
    error_log('AJAX delete_course error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Server error']);
}
