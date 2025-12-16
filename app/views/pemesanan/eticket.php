<!-- E-Ticket View -->
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-ticket-alt"></i> E-Ticket</h1>
    <div style="float: right;">
        <button onclick="window.print()" class="btn btn-secondary">Cetak</button>
    </div>
</div>

<div class="card eticket-card" style="max-width:800px; margin:20px auto; padding:24px; background:var(--surface-color); color:var(--text-color); border-radius:8px;">
    <?php if (empty($pem)): ?>
        <p>Data tiket tidak ditemukan.</p>
    <?php else: ?>
        <h2 style="margin-bottom:8px;"><?= htmlspecialchars($pem['nama_event'] ?? '-') ?></h2>
        <p style="margin:0 0 12px 0; color:var(--muted-color);"><?= htmlspecialchars($pem['nama_tiket'] ?? '-') ?> — <?= !empty($pem['tanggal_event']) ? date('d M Y', strtotime($pem['tanggal_event'])) : '-' ?> — <?= htmlspecialchars($pem['lokasi'] ?? '-') ?></p>

        <table style="width:100%; margin-top:12px;">
            <tr>
                <td><strong>Kode Booking</strong></td>
                <td><?= htmlspecialchars($pem['kode_booking']) ?></td>
            </tr>
            <tr>
                <td><strong>Nama</strong></td>
                <td><?= htmlspecialchars($pem['customer_nama'] ?? '-') ?></td>
            </tr>
            <tr>
                <td><strong>Email</strong></td>
                <td><?= htmlspecialchars($pem['customer_email'] ?? '-') ?></td>
            </tr>
            <tr>
                <td><strong>Jumlah Tiket</strong></td>
                <td><?= htmlspecialchars($pem['jumlah_tiket']) ?></td>
            </tr>
            <tr>
                <td><strong>Total Harga</strong></td>
                <td>Rp <?= number_format($pem['total_harga'], 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td><strong>Status</strong></td>
                <td><?= htmlspecialchars($pem['status']) ?></td>
            </tr>
        </table>

        <div style="margin-top:18px; text-align:center;">
            <div style="display:inline-block; padding:12px 18px; border:1px dashed var(--muted-color);">
                <strong>Scan untuk cek-in</strong>
                <div style="margin-top:8px; font-size:12px; color:var(--muted-color);">Kode: <?= htmlspecialchars($pem['kode_booking']) ?></div>
            </div>
        </div>
    <?php endif; ?>
</div>
