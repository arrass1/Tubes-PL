<!-- My Orders Content -->
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 class="page-title" style="margin-bottom: 0;"><i class="fas fa-receipt"></i> Pesanan Saya</h1>
    <a href="index.php?module=pemesanan&action=create" class="btn-submit" style="text-decoration: none; display: inline-block; margin-left: auto;">
        <i class="fas fa-plus"></i> Buat Pesanan
    </a>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="alert" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #28a745;">
        <i class="fas fa-check-circle"></i>
        Pesanan berhasil dibuat! Tunggu persetujuan dari admin.
    </div>
<?php endif; ?>

<div class="table-card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Kode Booking</th>
                    <th>Event</th>
                    <th>Tanggal Event</th>
                    <th>Jumlah Tiket</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Tanggal Pemesanan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pemesanan)): ?>
                    <tr>
                        <td colspan="8" style="text-align: center; color: #999;">
                            <i class="fas fa-inbox"></i> Anda belum memiliki pesanan. 
                            <a href="index.php?module=pemesanan&action=create" style="color: #7c3aed;">Buat pesanan sekarang</a>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pemesanan as $index => $p): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><strong><?= htmlspecialchars($p['kode_booking']) ?></strong></td>
                        <td><?= htmlspecialchars($p['nama_event'] ?? '-') ?></td>
                        <td><?= !empty($p['tanggal_event']) ? date('d M Y', strtotime($p['tanggal_event'])) : '-' ?></td>
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
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
