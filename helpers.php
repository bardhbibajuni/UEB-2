<?php
define('ROOT_DIR', __DIR__);
define('DATA_DIR', ROOT_DIR . '/data');
define('UPLOADS_DIR', ROOT_DIR . '/uploads');

function getData($file) {
    if (!file_exists($file)) return [];
    $data = @include $file;
    return is_array($data) ? $data : [];
}

function saveData($file, $data) {
    file_put_contents($file, '<?php return ' . var_export($data, true) . ';');
}

function initData() {
    if (!is_dir(DATA_DIR)) mkdir(DATA_DIR, 0755, true);
    if (!is_dir(UPLOADS_DIR)) mkdir(UPLOADS_DIR, 0755, true);

    $users = getData(DATA_DIR . '/users.php');
    if (empty($users)) {
        saveData(DATA_DIR . '/users.php', [
            [
                'id'        => 1,
                'firstname' => 'Admin',
                'lastname'  => 'User',
                'email'     => 'admin@brainboost.com',
                'password'  => password_hash('Admin123!', PASSWORD_DEFAULT),
                'role'      => 'admin'
            ]
        ]);
    }

    if (!file_exists(DATA_DIR . '/courses.php')) {
        saveData(DATA_DIR . '/courses.php', [
            [
                'id'          => 1,
                'title'       => 'PHP Basics',
                'description' => 'Learn PHP from zero to hero. Variables, loops, functions, OOP and more.',
                'price'       => 29.99,
                'instructor'  => 'Admin User',
                'file'        => '',
                'video_url'   => '',
                'created_at'  => date('Y-m-d')
            ],
            [
                'id'          => 2,
                'title'       => 'JavaScript Fundamentals',
                'description' => 'Master JavaScript essentials. DOM, events, fetch, async/await.',
                'price'       => 24.99,
                'instructor'  => 'Admin User',
                'file'        => '',
                'video_url'   => '',
                'created_at'  => date('Y-m-d')
            ]
        ]);
    }

    if (!file_exists(DATA_DIR . '/purchases.php')) {
        saveData(DATA_DIR . '/purchases.php', []);
    }
}

function nextId($arr) {
    if (empty($arr)) return 1;
    $ids = array_column($arr, 'id');
    return empty($ids) ? 1 : max($ids) + 1;
}

function hasPurchased($userId, $courseId) {
    $purchases = getData(DATA_DIR . '/purchases.php');
    foreach ($purchases as $p) {
        if ($p['user_id'] == $userId && $p['course_id'] == $courseId) return true;
    }
    return false;
}

function sanitize($input) {
    return htmlspecialchars(trim($input ?? ''), ENT_QUOTES, 'UTF-8');
}

function findUser($email) {
    $users = getData(DATA_DIR . '/users.php');
    foreach ($users as $user) {
        if ($user['email'] === strtolower(trim($email))) return $user;
    }
    return null;
}

function findCourse($id) {
    $courses = getData(DATA_DIR . '/courses.php');
    foreach ($courses as $course) {
        if ($course['id'] == $id) return $course;
    }
    return null;
}

initData();
