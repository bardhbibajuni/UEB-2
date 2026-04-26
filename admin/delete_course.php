<?php
include 'includes/header.php';

$id = intval($_GET['id'] ?? 0);

if ($id > 0) {
    $courses = getData(DATA_DIR . '/courses.php');
    foreach ($courses as $c) {
        if ($c['id'] == $id && !empty($c['file'])) {
            $f = ROOT_DIR . '/' . $c['file'];
            if (file_exists($f)) @unlink($f);
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
