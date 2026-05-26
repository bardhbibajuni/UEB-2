<?php
session_start();
require_once 'helpers.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user    = $_SESSION['user'];
$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname    = trim($_POST['firstname'] ?? '');
    $lastname     = trim($_POST['lastname']  ?? '');
    $email        = strtolower(trim($_POST['email'] ?? ''));
    $newPassword  = $_POST['new_password'] ?? '';
    $currentPw    = $_POST['current_password'] ?? '';

    try {
        $fresh = findUserById((int)$user['id']);
        if (!$fresh || !password_verify($currentPw, $fresh['password'])) {
            $error = 'Current password is incorrect.';
        } elseif (!validateName($firstname) || strlen($firstname) > 50) {
            $error = 'First name must be 2-50 letters.';
        } elseif (!validateName($lastname) || strlen($lastname) > 50) {
            $error = 'Last name must be 2-50 letters.';
        } elseif (!validateEmail($email)) {
            $error = 'Invalid email.';
        } else {
            $emailUser = findUser($email);
            if ($emailUser && (int)$emailUser['id'] !== (int)$user['id']) {
                $error = 'Email already in use by another account.';
            } elseif ($newPassword !== '' && !validatePassword($newPassword)) {
                $error = 'New password must be 6+ chars with letter, number, and special char.';
            } else {
                updateUser((int)$user['id'], $firstname, $lastname, $email);
                if ($newPassword !== '') {
                    updateUserPassword((int)$user['id'], $newPassword);
                }
                $_SESSION['user'] = findUserById((int)$user['id']);
                $user = $_SESSION['user'];
                $success = 'Profile updated successfully.';
            }
        }
    } catch (Exception $e) {
        $error = 'Server error.';
        error_log('profile.php error: ' . $e->getMessage());
    }
}

include 'header.php';
?>

<div class="form-wrapper">
    <div class="card wide-card" style="max-width:600px;">
        <h2>My Profile</h2>
        <p style="color:#9ca3af;text-align:center;margin-bottom:20px;">
            Update your personal information.
        </p>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= sanitize($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= sanitize($success) ?></div>
        <?php endif; ?>

        <form method="POST" autocomplete="off">
            <label>First Name</label>
            <input type="text" name="firstname" required
                   value="<?= sanitize($user['firstname']) ?>">

            <label>Last Name</label>
            <input type="text" name="lastname" required
                   value="<?= sanitize($user['lastname']) ?>">

            <label>Email</label>
            <input type="email" name="email" required
                   value="<?= sanitize($user['email']) ?>">

            <label>New Password (leave blank to keep current)</label>
            <input type="password" name="new_password"
                   placeholder="6+ chars, letter, number, special">

            <label>Current Password (required)</label>
            <input type="password" name="current_password" required
                   placeholder="Confirm with your current password">

            <button type="submit">Save Changes</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
