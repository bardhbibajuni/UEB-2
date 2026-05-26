<?php
include 'includes/header.php';

try {
    $db   = getDB();
    $stmt = $db->query('SELECT * FROM contact_messages ORDER BY created_at DESC');
    $messages = $stmt->fetchAll();
} catch (Exception $e) {
    $messages = [];
    error_log('messages.php error: ' . $e->getMessage());
}
?>

<div class="dashboard-wrapper">
    <h1 class="title">Contact Messages</h1>
    <p class="subtitle"><?= count($messages) ?> message(s) received</p>

    <div class="admin-table-wrap">
        <?php if (empty($messages)): ?>
            <p class="subtitle">No messages yet.</p>
        <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th><th>Name</th><th>Email</th>
                    <th>Message</th><th>Date</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($messages as $m): ?>
                <tr>
                    <td>#<?= $m['id'] ?></td>
                    <td><?= sanitize($m['name']) ?></td>
                    <td><?= sanitize($m['email']) ?></td>
                    <td style="max-width:300px;word-wrap:break-word;">
                        <?= nl2br(sanitize($m['message'])) ?>
                    </td>
                    <td><?= sanitize(substr($m['created_at'], 0, 16)) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
