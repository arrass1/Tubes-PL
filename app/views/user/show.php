<?php /** @var array $user */ ?>
<h2>Detail User</h2>
<?php if ($user): ?>
    <p><strong>ID:</strong> <?= htmlspecialchars($user['user_id']) ?></p>
    <p><strong>Nama:</strong> <?= htmlspecialchars($user['nama']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>No Telepon:</strong> <?= htmlspecialchars($user['no_telepon']) ?></p>
    <p><strong>Role:</strong> <?= htmlspecialchars($user['role']) ?></p>
<?php else: ?>
    <p>User tidak ditemukan.</p>
<?php endif; ?>
