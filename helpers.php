<?php

define('ROOT_DIR',    __DIR__);
define('UPLOADS_DIR', ROOT_DIR . '/uploads');

require_once __DIR__ . '/db.php';

function sanitize($input): string {
    return htmlspecialchars(trim((string)($input ?? '')), ENT_QUOTES, 'UTF-8');
}

function csrfToken(): string {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrfCheck(?string $token): bool {
    if (session_status() === PHP_SESSION_NONE) session_start();
    return !empty($token)
        && !empty($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);
}

function validateEmail(string $email): bool {
    $email = trim($email);
    if (strlen($email) > 150) return false;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return false;
    return (bool) preg_match('/^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/', $email);
}

function validatePassword(string $pw): bool {
    return (bool) preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&._\-]).{6,}$/', $pw);
}

function passwordStrength(string $pw): int {
    $score = 0;
    if (strlen($pw) >= 6)  $score++;
    if (strlen($pw) >= 10) $score++;
    if (preg_match('/[A-Z]/', $pw)) $score++;
    if (preg_match('/[a-z]/', $pw)) $score++;
    if (preg_match('/\d/',   $pw)) $score++;
    if (preg_match('/[@$!%*#?&._\-]/', $pw)) $score++;
    return min($score, 5);
}

function validateName(string $name): bool {
    return (bool) preg_match('/^[a-zA-Z]{2,}$/', $name);
}

function findUser(string $email): ?array {
    try {
        $db   = getDB();
        $stmt = $db->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([strtolower(trim($email))]);
        $row = $stmt->fetch();
        return $row ?: null;
    } catch (PDOException $e) {
        error_log('findUser error: ' . $e->getMessage());
        return null;
    }
}

function findUserById(int $id): ?array {
    try {
        $db   = getDB();
        $stmt = $db->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    } catch (PDOException $e) {
        error_log('findUserById error: ' . $e->getMessage());
        return null;
    }
}

function getAllUsers(): array {
    try {
        $db   = getDB();
        $stmt = $db->query('SELECT * FROM users ORDER BY created_at DESC');
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log('getAllUsers error: ' . $e->getMessage());
        return [];
    }
}

function createUser(string $firstname, string $lastname, string $email, string $password, string $role = 'user'): bool {
    try {
        $db   = getDB();
        $stmt = $db->prepare('INSERT INTO users (firstname, lastname, email, password, role) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([
            sanitize($firstname),
            sanitize($lastname),
            strtolower(trim($email)),
            password_hash($password, PASSWORD_DEFAULT),
            $role
        ]);
        return true;
    } catch (PDOException $e) {
        error_log('createUser error: ' . $e->getMessage());
        return false;
    }
}

function deleteUser(int $id): bool {
    try {
        $db   = getDB();
        $stmt = $db->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return true;
    } catch (PDOException $e) {
        error_log('deleteUser error: ' . $e->getMessage());
        return false;
    }
}

function findCourse(int $id): ?array {
    try {
        $db   = getDB();
        $stmt = $db->prepare('SELECT * FROM courses WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    } catch (PDOException $e) {
        error_log('findCourse error: ' . $e->getMessage());
        return null;
    }
}

function getAllCourses(string $search = ''): array {
    try {
        $db = getDB();
        if ($search !== '') {
            $stmt = $db->prepare('SELECT * FROM courses WHERE title LIKE ? OR description LIKE ? ORDER BY created_at DESC');
            $like = '%' . $search . '%';
            $stmt->execute([$like, $like]);
        } else {
            $stmt = $db->query('SELECT * FROM courses ORDER BY created_at DESC');
        }
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log('getAllCourses error: ' . $e->getMessage());
        return [];
    }
}

function createCourse(array $data): bool {
    try {
        $db   = getDB();
        $stmt = $db->prepare('INSERT INTO courses (title, description, price, instructor, file_path, video_url) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            sanitize($data['title']),
            sanitize($data['description']),
            floatval($data['price']),
            sanitize($data['instructor']),
            $data['file_path'] ?? null,
            sanitize($data['video_url'] ?? '')
        ]);
        return true;
    } catch (PDOException $e) {
        error_log('createCourse error: ' . $e->getMessage());
        return false;
    }
}

function updateCourse(int $id, array $data): bool {
    try {
        $db   = getDB();
        $stmt = $db->prepare('UPDATE courses SET title=?, description=?, price=?, video_url=?, file_path=? WHERE id=?');
        $stmt->execute([
            sanitize($data['title']),
            sanitize($data['description']),
            floatval($data['price']),
            sanitize($data['video_url'] ?? ''),
            $data['file_path'] ?? null,
            $id
        ]);
        return true;
    } catch (PDOException $e) {
        error_log('updateCourse error: ' . $e->getMessage());
        return false;
    }
}

function deleteCourse(int $id): bool {
    try {
        $db   = getDB();
        // Also delete physical file
        $course = findCourse($id);
        if ($course && !empty($course['file_path'])) {
            $path = ROOT_DIR . '/' . $course['file_path'];
            if (file_exists($path)) @unlink($path);
        }
        $stmt = $db->prepare('DELETE FROM courses WHERE id = ?');
        $stmt->execute([$id]);
        return true;
    } catch (PDOException $e) {
        error_log('deleteCourse error: ' . $e->getMessage());
        return false;
    }
}

function hasPurchased(int $userId, int $courseId): bool {
    try {
        $db   = getDB();
        $stmt = $db->prepare('SELECT id FROM purchases WHERE user_id = ? AND course_id = ? LIMIT 1');
        $stmt->execute([$userId, $courseId]);
        return (bool) $stmt->fetch();
    } catch (PDOException $e) {
        error_log('hasPurchased error: ' . $e->getMessage());
        return false;
    }
}

function createPurchase(int $userId, int $courseId): bool {
    try {
        $db   = getDB();
        $stmt = $db->prepare('INSERT IGNORE INTO purchases (user_id, course_id) VALUES (?, ?)');
        $stmt->execute([$userId, $courseId]);
        return true;
    } catch (PDOException $e) {
        error_log('createPurchase error: ' . $e->getMessage());
        return false;
    }
}

function getUserCourses(int $userId): array {
    try {
        $db   = getDB();
        $stmt = $db->prepare('
            SELECT c.* FROM courses c
            INNER JOIN purchases p ON c.id = p.course_id
            WHERE p.user_id = ?
            ORDER BY p.created_at DESC
        ');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log('getUserCourses error: ' . $e->getMessage());
        return [];
    }
}

function getAllPurchases(): array {
    try {
        $db   = getDB();
        $stmt = $db->query('SELECT * FROM purchases');
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

function countPurchasesForCourse(int $courseId): int {
    try {
        $db   = getDB();
        $stmt = $db->prepare('SELECT COUNT(*) FROM purchases WHERE course_id = ?');
        $stmt->execute([$courseId]);
        return (int) $stmt->fetchColumn();
    } catch (PDOException $e) {
        return 0;
    }
}

function saveContactMessage(string $name, string $email, string $message): bool {
    try {
        $db   = getDB();
        $stmt = $db->prepare('INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)');
        $stmt->execute([sanitize($name), sanitize($email), sanitize($message)]);
        return true;
    } catch (PDOException $e) {
        error_log('saveContactMessage error: ' . $e->getMessage());
        return false;
    }
}

function handleFileUpload(string $inputName): array {
    $result = ['path' => null, 'error' => ''];

    if (empty($_FILES[$inputName]['name'])) {
        return $result;
    }

    $origName = basename($_FILES[$inputName]['name']);
    $ext      = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
    $allowed  = ['pdf', 'mp4', 'mov', 'avi', 'mkv', 'zip'];

    if (!in_array($ext, $allowed)) {
        $result['error'] = 'Allowed file types: PDF, MP4, MOV, AVI, MKV, ZIP.';
        return $result;
    }
    if ($_FILES[$inputName]['size'] > 200 * 1024 * 1024) {
        $result['error'] = 'File too large (max 200 MB).';
        return $result;
    }

    if (!is_dir(UPLOADS_DIR)) mkdir(UPLOADS_DIR, 0755, true);

    $safeName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $origName);
    $dest     = UPLOADS_DIR . '/' . $safeName;

    try {
        if (!move_uploaded_file($_FILES[$inputName]['tmp_name'], $dest)) {
            $result['error'] = 'Failed to upload file. Check folder permissions.';
        } else {
            $result['path'] = 'uploads/' . $safeName;
        }
    } catch (Exception $e) {
        $result['error'] = 'File upload exception: ' . $e->getMessage();
    }

    return $result;
}
