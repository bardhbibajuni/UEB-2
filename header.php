<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!defined('ROOT_DIR')) {
    require_once __DIR__ . '/helpers.php';
}
?>
