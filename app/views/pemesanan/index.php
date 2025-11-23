<!-- Pemesanan Index Content -->
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-list-check"></i> Manajemen Pemesanan</h1>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="alert" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #28a745;">
        <i class="fas fa-check-circle"></i>
        <?php
        if ($_GET['success'] === 'approved') echo 'Pesanan berhasil disetujui!';
        elseif ($_GET['success'] === 'rejected') echo 'Pesanan berhasil ditolak!';
        elseif ($_GET['success'] === 'deleted') echo 'Pesanan berhasil dihapus!';
        ?>
    </div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="alert" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #dc3545;">
        <i class="fas fa-exclamation-circle"></i>
        Terjadi kesalahan!
    </div>
<?php endif; ?>

<div class="table-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h5 style="margin: 0;"><i class="fas fa-shopping-cart"></i> Daftar Pesanan</h5>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Kode Booking</th>
                    <th>Customer</th>
                    <th>Event</th>
                    <th>Jumlah Tiket</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pemesanan)): ?>
                    <tr>
                        <td colspan="9" style="text-align: center; color: #999;">Tidak ada pesanan</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pemesanan as $index => $p): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><strong><?= htmlspecialchars($p['kode_booking']) ?></strong></td>
                        <td><?= htmlspecialchars($p['customer_nama']) ?></td>
                        <td><?= htmlspecialchars($p['nama_event'] ?? '-') ?></td>
                        <td style="text-align: center;"><?= $p['jumlah_tiket'] ?></td>
                        <td style="color: #10b981; font-weight: bold;">Rp <?= number_format($p['total_harga'], 0, ',', '.') ?></td>
                        <td>
                            <span class="badge" style="padding: 6px 12px; border-radius: 4px; color: white; font-size: 12px; background: <?php
                                if ($p['status'] === 'Pending') echo '#ffc107';
                                elseif ($p['status'] === 'Disetujui') echo '#28a745';
                                else echo '#dc3545';
                            ?>;">
                                <?= htmlspecialchars($p['status']) ?>
                            </span>
                        </td>
                        <td><?= date('d M Y', strtotime($p['tanggal_pemesanan'])) ?></td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <?php if ($p['status'] === 'Pending'): ?>
                                    <a href="index.php?module=pemesanan&action=approve&id=<?= $p['id'] ?>" 
                                       class="btn-action" style="background: #28a745; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; cursor: pointer;"
                                       onclick="return confirm('Setujui pesanan ini?')">
                                        <i class="fas fa-check"></i> Setujui
                                    </a>
                                    <a href="index.php?module=pemesanan&action=reject&id=<?= $p['id'] ?>" 
                                       class="btn-action" style="background: #dc3545; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; cursor: pointer;"
                                       onclick="return confirm('Tolak pesanan ini?')">
                                        <i class="fas fa-times"></i> Tolak
                                    </a>
                                <?php endif; ?>
                                <a href="index.php?module=pemesanan&action=delete&id=<?= $p['id'] ?>" 
                                   class="btn-action" style="background: #6c757d; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; cursor: pointer;"
                                   onclick="return confirm('Hapus pesanan ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
