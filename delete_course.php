<?php
session_start();
require_once 'helpers.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$id = intval($_GET['id'] ?? 0);

if ($id > 0) {
    try {
        deleteCourse($id);
    } catch (Exception $e) {
        error_log('delete_course error: ' . $e->getMessage());
    }
}

header('Location: courses.php');
exit;
