<!-- User Index Content -->
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-users"></i> Manajemen Customer</h1>
    <a href="index.php?module=user&action=create" class="btn-primary">
        <i class="fas fa-plus"></i> Tambah Customer
    </a>
</div>

<?php if (isset($_GET['message'])): ?>
    <?php if ($_GET['message'] === 'success_create'): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> Customer berhasil ditambahkan!
        </div>
    <?php elseif ($_GET['message'] === 'success_update'): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> Customer berhasil diperbarui!
        </div>
    <?php elseif ($_GET['message'] === 'success_delete'): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> Customer berhasil dihapus!
        </div>
    <?php elseif (strpos($_GET['message'], 'error') !== false): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> Terjadi kesalahan!
        </div>
    <?php endif; ?>
<?php endif; ?>

<div class="table-card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No Telepon</th>
                    <th>Role</th>
                    <th>Tanggal Daftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; color: #999;">
                            <i class="fas fa-inbox"></i> Tidak ada data customer
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td><?= htmlspecialchars($u['user_id']) ?></td>
                            <td><?= htmlspecialchars($u['nama']) ?></td>
                            <td><?= htmlspecialchars($u['email']) ?></td>
                            <td><?= htmlspecialchars($u['no_telepon'] ?? '–') ?></td>
                            <td>
                                <span class="badge" style="background: <?= $u['role'] === 'member' ? '#10b981' : '#3b82f6' ?>">
                                    <?= htmlspecialchars($u['role']) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars(substr($u['tanggal_daftar'], 0, 10)) ?></td>
                            <td>
                                <a href="index.php?module=user&action=edit&id=<?= $u['user_id'] ?>" class="btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form method="POST" action="index.php?module=user&action=delete&id=<?= $u['user_id'] ?>" style="display:inline;">
                                    <button type="submit" class="btn-delete" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
