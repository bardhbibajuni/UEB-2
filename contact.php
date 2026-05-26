<?php
session_start();
require_once 'helpers.php';
include 'header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $message = trim($_POST['message'] ?? '');

    try {
        if (strlen($name) < 2 || strlen($name) > 100) {
            $error = 'Name must be 2-100 characters.';
        } elseif (!validateEmail($email)) {
            $error = 'Please enter a valid email address.';
        } elseif (strlen($message) < 10) {
            $error = 'Message must be at least 10 characters.';
        } elseif (strlen($message) > 400) {
            $error = 'Message can\'t be longer than 400 characters.';
        } else {
            saveContactMessage($name, $email, $message);

            $to = 'admin@brainboost.com';
            $subject = 'New Contact Message from ' . sanitize($name);
            $body = "Name: " . sanitize($name) . "\n"
                . "Email: " . sanitize($email) . "\n\n"
                . "Message:\n" . sanitize($message);
            $headers = "From: noreply@brainboost.com\r\n"
                . "Reply-To: " . sanitize($email) . "\r\n"
                . "X-Mailer: PHP/" . phpversion();

            @mail($to, $subject, $body, $headers);

            $success = 'Your message has been sent! We will get back to you soon.';
        }
    } catch (Exception $e) {
        $error = 'Server error. Please try again later.';
        error_log('contact.php error: ' . $e->getMessage());
    }
}
?>

<div class="form-wrapper">
    <div class="card wide-card" style="max-width:600px;">
        <h2>📬 Contact Us</h2>
        <p style="color:#9ca3af;text-align:center;margin-bottom:20px;">
            Have a question or feedback? We'd love to hear from you.
        </p>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= sanitize($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= sanitize($success) ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>Your Name</label>
            <input type="text" name="name" placeholder="John Doe" required
                value="<?= sanitize($_POST['name'] ?? '') ?>">

            <label>Email Address</label>
            <input type="email" name="email" placeholder="you@example.com" required
                value="<?= sanitize($_POST['email'] ?? '') ?>">

            <label>Message</label>
            <textarea name="message" rows="6" placeholder="Write your message here..."
                required><?= sanitize($_POST['message'] ?? '') ?></textarea>

            <button type="submit">Send Message</button>
        </form>

        <br>
        <p style="color:#6b7280;font-size:13px;text-align:center;">
            We typically respond within 24 hours.
        </p>
    </div>
</div>

<?php include 'footer.php'; ?>