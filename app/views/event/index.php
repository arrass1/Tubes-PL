<!-- Event Index Content -->
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-calendar"></i> Manajemen Event</h1>
    <div style="display: flex; gap: 15px; align-items: center;">
        <form method="GET" action="index.php" class="search-box" style="flex: 1; max-width: 400px;">
            <input type="hidden" name="module" value="event">
            <i class="fas fa-search"></i>
            <input type="text" name="search" class="form-control" placeholder="Cari event..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
        </form>
        <a href="index.php?module=event&action=create" class="btn-primary">
            <i class="fas fa-plus"></i> Tambah Event
        </a>
    </div>
</div>

<?php if (isset($_GET['message'])): ?>
    <?php if (strpos($_GET['message'], 'success') !== false): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <?php
                $messages = [
                    'success_create' => 'Event berhasil ditambahkan!',
                    'success_update' => 'Event berhasil diperbarui!',
                    'success_delete' => 'Event berhasil dihapus!'
                ];
                echo $messages[$_GET['message']] ?? 'Operasi berhasil!';
            ?>
        </div>
    <?php else: ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <?php
                $messages = [
                    'error_create' => 'Gagal menambahkan event!',
                    'error_update' => 'Gagal memperbarui event!',
                    'error_delete' => 'Gagal menghapus event!',
                    'not_found' => 'Event tidak ditemukan!'
                ];
                echo $messages[$_GET['message']] ?? 'Terjadi kesalahan!';
            ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<div class="table-card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nama Event</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                    <th>Harga</th>
                    <th>Kapasitas</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($events)): ?>
                    <tr>
                        <td colspan="9" style="text-align: center; color: #999;">
                            <i class="fas fa-inbox"></i> Tidak ada data event
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($events as $index => $event): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($event['nama_event']) ?></td>
                            <td><?= date('d M Y', strtotime($event['tanggal_event'])) ?></td>
                            <td><?= htmlspecialchars($event['lokasi']) ?></td>
                            <td>Rp <?= number_format($event['harga_tiket'], 0, ',', '.') ?></td>
                            <td><?= number_format($event['kapasitas']) ?></td>
                            <td><span class="badge" style="background: #3b82f6;"><?= htmlspecialchars($event['kategori']) ?></span></td>
                            <td>
                                <span class="badge" style="background: <?= $event['status'] == 'Aktif' ? '#10b981' : ($event['status'] == 'Selesai' ? '#6c757d' : '#ef4444') ?>">
                                    <?= htmlspecialchars($event['status']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="index.php?module=event&action=edit&id=<?= $event['id'] ?>" class="btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="index.php?module=event&action=delete&id=<?= $event['id'] ?>" class="btn-delete" style="background: #ef4444;" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>