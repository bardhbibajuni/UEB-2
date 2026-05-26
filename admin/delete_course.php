<?php
include 'includes/header.php';

$id = intval($_GET['id'] ?? 0);

if ($id > 0) {
    try {
        deleteCourse($id);
    } catch (Exception $e) {
        error_log('admin delete_course error: ' . $e->getMessage());
    }
}

header('Location: courses.php');
exit;
