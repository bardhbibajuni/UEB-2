<?php
session_start();
require_once 'helpers.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$id = intval($_GET['id'] ?? 0);

if ($id > 0) {
    $courses = getData(DATA_DIR . '/courses.php');

    foreach ($courses as $course) {
        if ($course['id'] == $id && !empty($course['file'])) {
            $filePath = ROOT_DIR . '/' . $course['file'];
            if (file_exists($filePath)) @unlink($filePath);
        }
    }

    $courses = array_values(array_filter($courses, fn($c) => $c['id'] != $id));
    saveData(DATA_DIR . '/courses.php', $courses);

    $purchases = array_values(array_filter(
        getData(DATA_DIR . '/purchases.php'),
        fn($p) => $p['course_id'] != $id
    ));
    saveData(DATA_DIR . '/purchases.php', $purchases);
}

header('Location: courses.php');
exit;
