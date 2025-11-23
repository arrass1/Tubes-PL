<!-- Dashboard Content -->
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-chart-line"></i> Dashboard</h1>
</div>

<?php if (isset($_SESSION['admin_role'])): ?>
<!-- Admin Dashboard with Orders -->
<div
    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="stats-card">
        <div class="icon bg-blue">
            <i class="fas fa-calendar"></i>
        </div>
        <div>
            <h3><?= $stats['total_events'] ?></h3>
            <p>Total Event</p>
        </div>
    </div>

    <div class="stats-card">
        <div class="icon bg-green">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div>
            <h3><?= $stats['total_orders'] ?></h3>
            <p>Total Pesanan</p>
        </div>
    </div>

    <div class="stats-card">
        <div class="icon bg-yellow">
            <i class="fas fa-clock"></i>
        </div>
        <div>
            <h3><?= $stats['pending_orders'] ?></h3>
            <p>Pesanan Pending</p>
        </div>
    </div>

    <div class="stats-card">
        <div class="icon bg-purple">
            <i class="fas fa-check-circle"></i>
        </div>
        <div>
            <h3><?= $stats['approved_orders'] ?></h3>
            <p>Pesanan Disetujui</p>
        </div>
    </div>

    <div class="stats-card">
        <div class="icon bg-red">
            <i class="fas fa-times-circle"></i>
        </div>
        <div>
            <h3><?= $stats['rejected_orders'] ?></h3>
            <p>Pesanan Ditolak</p>
        </div>
    </div>

    <div class="stats-card">
        <div class="icon bg-orange">
            <i class="fas fa-dollar-sign"></i>
        </div>
        <div>
            <h3>Rp <?= number_format($stats['total_revenue'], 0, ',', '.') ?></h3>
            <p>Total Revenue</p>
        </div>
    </div>
</div>

<!-- Orders Table for Admin -->
<div class="table-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h5 style="margin: 0;"><i class="fas fa-shopping-cart"></i> Pesanan Terbaru</h5>
        <a href="index.php?module=pemesanan" style="color: #7c3aed; text-decoration: none; font-size: 14px;">
            Lihat Semua Pesanan <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
        </a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Kode Booking</th>
                    <th>Customer</th>
                    <th>Event</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($recentPemesanan)): ?>
                <tr>
                    <td colspan="8" style="text-align: center; color: #999;">Tidak ada pesanan</td>
                </tr>
                <?php else: ?>
                <?php foreach (array_slice($recentPemesanan, 0, 5) as $index => $p): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><strong><?= htmlspecialchars($p['kode_booking']) ?></strong></td>
                    <td><?= htmlspecialchars($p['customer_nama']) ?></td>
                    <td><?= htmlspecialchars($p['nama_event'] ?? '-') ?></td>
                    <td style="text-align: center;"><?= $p['jumlah_tiket'] ?></td>
                    <td style="color: #10b981; font-weight: bold;">Rp
                        <?= number_format($p['total_harga'], 0, ',', '.') ?></td>
                    <td>
                        <span class="badge" style="padding: 4px 8px; border-radius: 4px; color: white; font-size: 11px; background: <?php
                                if ($p['status'] === 'Pending') echo '#ffc107';
                                elseif ($p['status'] === 'Disetujui') echo '#28a745';
                                else echo '#dc3545';
                            ?>;">
                            <?= htmlspecialchars($p['status']) ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($p['status'] === 'Pending'): ?>
                        <a href="index.php?module=pemesanan&action=approve&id=<?= $p['id'] ?>"
                            style="color: #28a745; text-decoration: none; font-size: 12px; cursor: pointer;"
                            onclick="return confirm('Setujui?')">
                            <i class="fas fa-check"></i>
                        </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php else: ?>
<!-- User Dashboard -->
<div
    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="stats-card">
        <div class="icon bg-blue">
            <i class="fas fa-calendar"></i>
        </div>
        <div>
            <h3><?= $stats['total_events'] ?></h3>
            <p>Total Event</p>
        </div>
    </div>

    <div class="stats-card">
        <div class="icon bg-green">
            <i class="fas fa-star"></i>
        </div>
        <div>
            <h3><?= $stats['upcoming_events'] ?></h3>
            <p>Event Mendatang</p>
        </div>
    </div>

    <div class="stats-card">
        <div class="icon bg-yellow">
            <i class="fas fa-ticket-alt"></i>
        </div>
        <div>
            <h3><?= $stats['total_tickets'] ?></h3>
            <p>Total Tiket Terjual</p>
        </div>
    </div>

    <div class="stats-card">
        <div class="icon bg-orange">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div>
            <a href="index.php?module=pemesanan&action=create"
                style="color: #7c3aed; text-decoration: none; font-weight: 600; font-size: 18px;">+ Buat Pesanan</a>
            <p>Pesan Tiket Event Impian Anda</p>
        </div>
    </div>
</div>

<div class="table-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h5 style="margin: 0;"><i class="fas"></i> Event Terbaru</h5>
        <a href="index.php?module=event" style="color: #7c3aed; text-decoration: none; font-size: 14px;">
            Lihat Semua Event <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
        </a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nama Event</th>
                    <th>Tanggal</th>
                    <th>Harga</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($recentEvents)): ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: #999;">Tidak ada event</td>
                </tr>
                <?php else: ?>
                <?php foreach (array_slice($recentEvents, 0, 5) as $index => $event): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td>
                        <i class="fas fa-music" style="color: #7c3aed; margin-right: 8px;"></i>
                        <strong><?= htmlspecialchars($event['nama_event']) ?></strong>
                    </td>
                    <td><?= date('d M Y', strtotime($event['tanggal_event'])) ?></td>
                    <td style="color: #10b981; font-weight: bold;">Rp
                        <?= number_format($event['harga_tiket'], 0, ',', '.') ?></td>
                    <td>
                        <span class="badge"
                            style="background: <?= $event['status'] == 'Aktif' ? '#10b981' : '#6c757d' ?>; padding: 6px 12px; border-radius: 4px; color: white; font-size: 12px;">
                            <?= htmlspecialchars($event['status']) ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="table-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h5 style="margin: 0;"><i class="fas fa-list"></i> Event Terbaru</h5>
        <a href="index.php?module=event" style="color: #7c3aed; text-decoration: none; font-size: 14px;">
            Lihat Semua Event <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
        </a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nama Event</th>
                    <th>Tanggal</th>
                    <th>Harga</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($recentEvents)): ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: #999;">Tidak ada event</td>
                </tr>
                <?php else: ?>
                <?php foreach (array_slice($recentEvents, 0, 5) as $index => $event): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td>
                        <i class="fas fa-music" style="color: #7c3aed; margin-right: 8px;"></i>
                        <strong><?= htmlspecialchars($event['nama_event']) ?></strong>
                    </td>
                    <td><?= date('d M Y', strtotime($event['tanggal_event'])) ?></td>
                    <td style="color: #10b981; font-weight: bold;">Rp
                        <?= number_format($event['harga_tiket'], 0, ',', '.') ?></td>
                    <td>
                        <span class="badge"
                            style="background: <?= $event['status'] == 'Aktif' ? '#10b981' : '#6c757d' ?>; padding: 6px 12px; border-radius: 4px; color: white; font-size: 12px;">
                            <?= htmlspecialchars($event['status']) ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php endif; ?>