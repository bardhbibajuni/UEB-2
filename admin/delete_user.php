<?php
include 'includes/header.php';

$id = intval($_GET['id'] ?? 0);

if ($id > 0 && $id !== $_SESSION['user']['id']) {
    $users = array_values(array_filter(
        getData(DATA_DIR . '/users.php'),
        fn($u) => $u['id'] != $id
    ));
    saveData(DATA_DIR . '/users.php', $users);

    $purchases = array_values(array_filter(
        getData(DATA_DIR . '/purchases.php'),
        fn($p) => $p['user_id'] != $id
    ));
    saveData(DATA_DIR . '/purchases.php', $purchases);
}

header('Location: users.php');
exit;
