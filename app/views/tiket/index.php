<!-- Tiket Index Content -->
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-ticket-alt"></i> Manajemen Tiket</h1>
    <a href="index.php?module=tiket&action=create" class="btn-primary">
        <i class="fas fa-plus"></i> Tambah Tiket
    </a>
</div>

<?php if (isset($_GET['message'])): ?>
    <?php if ($_GET['message'] === 'success_create'): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> Tiket berhasil ditambahkan!
        </div>
    <?php elseif ($_GET['message'] === 'success_update'): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> Tiket berhasil diperbarui!
        </div>
    <?php elseif ($_GET['message'] === 'success_delete'): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> Tiket berhasil dihapus!
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
                    <th>Event</th>
                    <th>Nama Tiket</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($tiket)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; color: #999;">
                            <i class="fas fa-inbox"></i> Tidak ada data tiket
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($tiket as $t): ?>
                        <tr>
                            <td><?= htmlspecialchars($t['id']) ?></td>
                            <td><?= htmlspecialchars($t['nama_event'] ?? '–') ?></td>
                            <td><?= htmlspecialchars($t['nama_tiket']) ?></td>
                            <td>Rp <?= number_format($t['harga'], 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars($t['stok']) ?></td>
                            <td><?= htmlspecialchars(substr($t['created_at'], 0, 10)) ?></td>
                            <td>
                                <a href="index.php?module=tiket&action=edit&id=<?= $t['id'] ?>" class="btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form method="POST" action="index.php?module=tiket&action=delete&id=<?= $t['id'] ?>" style="display:inline;">
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
