<?php
session_start();
require_once 'helpers.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$id     = intval($_GET['id'] ?? 0);
$course = findCourse($id);
$userId = (int)$_SESSION['user']['id'];

if (!$course) {
    header('Location: courses.php');
    exit;
}

if (!hasPurchased($userId, $id) && $_SESSION['user']['role'] !== 'admin') {
    http_response_code(403);
    exit('Access denied. You must purchase this course first.');
}

if (empty($course['file_path'])) {
    exit('No file available for this course yet.');
}

$filePath = ROOT_DIR . '/' . $course['file_path'];

if (!file_exists($filePath)) {
    exit('File not found on server.');
}

try {
    $filename = basename($filePath);
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . filesize($filePath));
    header('Cache-Control: no-cache');
    readfile($filePath);
    exit;
} catch (Exception $e) {
    error_log('download error: ' . $e->getMessage());
    exit('Download failed.');
}
