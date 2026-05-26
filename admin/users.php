<?php
include 'includes/header.php';

$search = trim($_GET['search'] ?? '');
$users  = getAllUsers();

if ($search !== '') {
    $users = array_filter($users, function($u) use ($search) {
        return stripos($u['email'],     $search) !== false
            || stripos($u['firstname'], $search) !== false
            || stripos($u['lastname'],  $search) !== false;
    });
}

$purchases = getAllPurchases();
?>

<div class="dashboard-wrapper">
    <h1 class="title">Manage Users</h1>

    <form method="GET" class="search-form" style="max-width:500px;margin:0 auto 30px;">
        <input type="text" name="search" placeholder="Search by name or email..." value="<?= sanitize($search) ?>">
        <button type="submit">Search</button>
        <?php if ($search): ?>
            <a href="users.php" style="color:#9ca3af;margin-left:10px;">Clear</a>
        <?php endif; ?>
    </form>

    <div class="admin-table-wrap">
        <?php if (empty($users)): ?>
            <p class="subtitle">No users found.</p>
        <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th><th>Name</th><th>Email</th>
                    <th>Role</th><th>Purchases</th><th>Registered</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $u): ?>
                <?php
                $userPurchases = count(array_filter($purchases, fn($p) => $p['user_id'] == $u['id']));
                $isSelf = $u['id'] == $_SESSION['user']['id'];
                ?>
                <tr>
                    <td>#<?= $u['id'] ?></td>
                    <td><?= sanitize($u['firstname']) . ' ' . sanitize($u['lastname']) ?></td>
                    <td><?= sanitize($u['email']) ?></td>
                    <td>
                        <span class="role-badge <?= $u['role'] === 'admin' ? 'role-admin' : 'role-user' ?>"
                              id="role-<?= $u['id'] ?>">
                            <?= ucfirst($u['role']) ?>
                        </span>
                    </td>
                    <td><?= $userPurchases ?></td>
                    <td><?= sanitize(substr($u['created_at'], 0, 10)) ?></td>
                    <td>
                        <?php if (!$isSelf): ?>
                            <a href="#" class="btn-card btn-edit"
                               onclick="toggleRole(<?= $u['id'] ?>, this); return false;">
                                Toggle Role
                            </a>
                            <a href="delete_user.php?id=<?= $u['id'] ?>"
                               class="btn-card btn-delete"
                               onclick="return confirm('Delete user <?= sanitize($u['email']) ?>?')">Delete</a>
                        <?php else: ?>
                            <span style="color:#9ca3af;font-size:12px;">You</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<script>
function toggleRole(id, btn) {
    if (!confirm('Toggle this user role?')) return;
    btn.textContent = '...';
    fetch('../ajax/toggle_user_role.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id=' + id
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const badge = document.getElementById('role-' + id);
            badge.textContent = data.role.charAt(0).toUpperCase() + data.role.slice(1);
            badge.className = 'role-badge ' + (data.role === 'admin' ? 'role-admin' : 'role-user');
            btn.textContent = 'Toggle Role';
        } else {
            alert(data.message || 'Error');
            btn.textContent = 'Toggle Role';
        }
    })
    .catch(() => { btn.textContent = 'Toggle Role'; });
}
</script>

<?php include 'includes/footer.php'; ?>
