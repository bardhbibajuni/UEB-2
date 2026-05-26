<?php
include 'includes/header.php';

$id = intval($_GET['id'] ?? 0);

if ($id > 0 && $id !== (int)$_SESSION['user']['id']) {
    try {
        deleteUser($id);
    } catch (Exception $e) {
        error_log('delete_user error: ' . $e->getMessage());
    }
}

header('Location: users.php');
exit;
