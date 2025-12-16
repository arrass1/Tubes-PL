<!-- My Orders Content -->
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-receipt"></i> Pesanan Saya</h1>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
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
                        <td colspan="8" style="text-align: center; color: var(--muted-color);">
                            <i class="fas fa-inbox"></i> Anda belum memiliki pesanan.
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
                        <td style="color: var(--muted-color); font-weight: bold;">Rp <?= number_format($p['total_harga'], 0, ',', '.') ?></td>
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