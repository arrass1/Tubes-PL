<!-- E-Tiket Content -->
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-ticket-alt"></i> E-Tiket Anda</h1>
</div>

<div style="text-align: center; margin: 30px 0;">
    <div style="background: rgba(16,185,129,0.06); padding: 20px; border-radius: 8px; display: inline-block; border-left: 4px solid #10b981;">
        <i class="fas fa-check-circle" style="color: var(--muted-color); font-size: 24px;"></i>
        <div style="color: var(--muted-color); font-weight: bold; margin-top: 10px; font-size: 18px;">
            Pembayaran Berhasil!
        </div>
        <div style="color: var(--muted-color); margin-top: 5px;">
            Terima kasih telah melakukan pembayaran. E-Tiket Anda sudah siap.
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-top: 30px;">
    <!-- E-Ticket Card -->
    <div>
        <div class="form-card" style="padding: 0; overflow: hidden;">
            <!-- Ticket Header -->
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; color: white;">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <div>
                        <h2 style="margin: 0 0 10px 0; font-size: 28px;">
                            <?= htmlspecialchars($tiket['nama_event']) ?>
                        </h2>
                        <div style="opacity: 0.9; font-size: 14px;">
                            <i class="fas fa-ticket-alt"></i> E-Ticket
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div style="background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 20px; font-size: 12px; margin-bottom: 8px;">
                            <i class="fas fa-check-circle"></i> VERIFIED
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ticket Body -->
            <div style="padding: 30px;">
                <!-- QR Code Section -->
                        <div style="text-align: center; margin-bottom: 30px; padding: 25px; background: var(--card-bg); border-radius: 12px; border: 2px dashed var(--border-color);">
                        <div style="width: 200px; height: 200px; margin: 0 auto; background: var(--card-bg); padding: 15px; border-radius: 8px; box-shadow: 0 8px 20px var(--shadow-color);">
                        <!-- QR Code Placeholder -->
                        <div style="width: 100%; height: 100%; background: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 200 200%22><rect fill=%22%23000%22 width=%2210%22 height=%2210%22 x=%2210%22 y=%2210%22/><rect fill=%22%23000%22 width=%2210%22 height=%2210%22 x=%2230%22 y=%2210%22/><rect fill=%22%23000%22 width=%2210%22 height=%2210%22 x=%2250%22 y=%2210%22/><rect fill=%22%23000%22 width=%2210%22 height=%2210%22 x=%2210%22 y=%2230%22/><rect fill=%22%23000%22 width=%2210%22 height=%2210%22 x=%2250%22 y=%2230%22/><rect fill=%22%23000%22 width=%2210%22 height=%2210%22 x=%2210%22 y=%2250%22/><rect fill=%22%23000%22 width=%2210%22 height=%2210%22 x=%2230%22 y=%2250%22/><rect fill=%22%23000%22 width=%2210%22 height=%2210%22 x=%2250%22 y=%2250%22/></svg>') center/cover no-repeat;"></div>
                    </div>
                        <div style="margin-top: 15px; font-size: 13px; color: var(--muted-color);">
                        <i class="fas fa-qrcode"></i> Scan QR Code ini saat masuk event
                    </div>
                    <div style="margin-top: 10px; font-family: monospace; font-weight: bold; color: #7c3aed; font-size: 16px;">
                        <?= htmlspecialchars($tiket['kode_pembayaran']) ?>
                    </div>
                </div>

                <!-- Ticket Details -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 25px;">
                    <div>
                        <div style="color: var(--muted-color); font-size: 13px; margin-bottom: 5px;">Kode Booking</div>
                        <div style="font-weight: bold; color: var(--text-color); font-family: monospace;">
                            <?= htmlspecialchars($tiket['kode_booking']) ?>
                        </div>
                    </div>
                    <div>
                        <div style="color: var(--muted-color); font-size: 13px; margin-bottom: 5px;">Tanggal Pembayaran</div>
                        <div style="font-weight: bold; color: var(--text-color);">
                            <?= date('d M Y, H:i', strtotime($tiket['tanggal_bayar'])) ?>
                        </div>
                    </div>
                    <div>
                        <div style="color: var(--muted-color); font-size: 13px; margin-bottom: 5px;">Nama Pemesan</div>
                        <div style="font-weight: bold; color: var(--text-color);">
                            <?= htmlspecialchars($tiket['customer_nama']) ?>
                        </div>
                    </div>
                    <div>
                        <div style="color: var(--muted-color); font-size: 13px; margin-bottom: 5px;">Email</div>
                        <div style="font-weight: bold; color: var(--text-color);">
                            <?= htmlspecialchars($tiket['customer_email']) ?>
                        </div>
                    </div>
                </div>

                <!-- Event Details -->
                <div style="border-top: 2px solid var(--border-color); padding-top: 25px; margin-top: 25px;">
                    <h4 style="color: var(--text-color); margin-bottom: 20px; font-size: 16px;">
                        <i class="fas fa-info-circle"></i> Detail Event
                    </h4>
                    <div style="display: grid; gap: 15px;">
                        <div style="display: flex; gap: 15px;">
                            <div style="color: #7c3aed; width: 30px;">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div>
                                <div style="color: var(--muted-color); font-size: 13px;">Tanggal Event</div>
                                <div style="font-weight: bold; color: var(--text-color);">
                                    <?= date('l, d F Y', strtotime($tiket['tanggal_event'])) ?>
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; gap: 15px;">
                            <div style="color: #dc3545; width: 30px;">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <div style="color: var(--muted-color); font-size: 13px;">Lokasi</div>
                                <div style="font-weight: bold; color: var(--text-color);">
                                    <?= htmlspecialchars($tiket['lokasi']) ?>
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; gap: 15px;">
                            <div style="color: var(--muted-color); width: 30px;">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                            <div>
                                <div style="color: var(--muted-color); font-size: 13px;">Jenis Tiket</div>
                                <div style="font-weight: bold; color: var(--text-color);">
                                    <?= htmlspecialchars($tiket['nama_tiket']) ?> (<?= $tiket['jumlah_tiket'] ?> Tiket)
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; gap: 15px;">
                            <div style="color: #ffc107; width: 30px;">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <div>
                                <div style="color: var(--muted-color); font-size: 13px;">Metode Pembayaran</div>
                                <div style="font-weight: bold; color: var(--text-color);">
                                    <?= htmlspecialchars($tiket['metode_pembayaran']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total -->
                <div style="border-top: 2px solid var(--border-color); margin-top: 25px; padding-top: 25px; text-align: right;">
                    <div style="color: var(--muted-color); font-size: 14px; margin-bottom: 5px;">Total Pembayaran</div>
                    <div style="font-size: 28px; font-weight: bold; color: #10b981;">
                        Rp <?= number_format($tiket['total_harga'], 0, ',', '.') ?>
                    </div>
                </div>

                <!-- Important Notes -->
                <div style="background: rgba(245,158,11,0.06); border-left: 4px solid #f59e0b; padding: 20px; border-radius: 8px; margin-top: 30px;">
                    <h5 style="color: #f59e0b; margin-bottom: 12px; font-size: 14px;">
                        <i class="fas fa-exclamation-triangle"></i> Penting!
                    </h5>
                    <ul style="margin: 0; padding-left: 20px; color: #f59e0b; font-size: 13px; line-height: 1.8;">
                        <li>Simpan e-tiket ini dengan baik</li>
                        <li>Tunjukkan QR Code saat masuk lokasi event</li>
                        <li>Datang 30 menit sebelum event dimulai</li>
                        <li>E-tiket tidak dapat dipindahtangankan</li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; gap: 15px; margin-top: 30px;">
                    <button onclick="window.print()" class="btn-submit" style="flex: 1; border: none; cursor: pointer;">
                        <i class="fas fa-print"></i> Cetak E-Tiket
                    </button>
                    <a href="index.php?module=pemesanan&action=my_orders" class="btn-cancel" style="text-decoration: none; text-align: center;">
                        <i class="fas fa-list"></i> Lihat Pesanan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar - Event Preview -->
    <div>
        <div class="form-card" style="padding: 25px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; position: sticky; top: 20px;">
            <h4 style="margin-bottom: 20px; font-size: 18px; border-bottom: 1px solid rgba(255,255,255,0.3); padding-bottom: 15px;">
                <i class="fas fa-calendar-check"></i> Event Anda
            </h4>
            
            <div style="margin-bottom: 20px;">
                <div style="font-size: 13px; opacity: 0.9; margin-bottom: 5px;">Nama Event</div>
                <div style="font-weight: bold; font-size: 18px; line-height: 1.4;">
                    <?= htmlspecialchars($tiket['nama_event']) ?>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="font-size: 13px; opacity: 0.9; margin-bottom: 5px;">
                    <i class="fas fa-calendar"></i> Tanggal
                </div>
                <div style="font-weight: bold;">
                    <?= date('d F Y', strtotime($tiket['tanggal_event'])) ?>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="font-size: 13px; opacity: 0.9; margin-bottom: 5px;">
                    <i class="fas fa-map-marker-alt"></i> Lokasi
                </div>
                <div style="font-weight: bold; line-height: 1.4;">
                    <?= htmlspecialchars($tiket['lokasi']) ?>
                </div>
            </div>

            <div style="margin-top: 25px; padding: 15px; background: rgba(255,255,255,0.1); border-radius: 8px; font-size: 13px; text-align: center;">
                <i class="fas fa-check-circle"></i> Tiket Valid & Terverifikasi
            </div>

            <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.3);">
                <div style="font-size: 13px; opacity: 0.9; text-align: center;">
                    Jangan lupa untuk datang tepat waktu!
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .page-header, .btn-submit, .btn-cancel, nav, footer {
        display: none !important;
    }
}
</style>