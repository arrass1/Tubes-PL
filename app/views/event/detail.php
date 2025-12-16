<!-- Event Detail Content -->
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-calendar-alt"></i> Detail Event</h1>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-top: 30px;">
    <!-- Main Content -->
    <div>
        <div class="form-card" style="padding: 30px;">
            <!-- Event Header -->
            <div style="border-bottom: 2px solid #e5e7eb; padding-bottom: 20px; margin-bottom: 25px;">
                <h2 style="color: #7c3aed; margin-bottom: 10px; font-size: 28px;">
                    <?= htmlspecialchars($event['nama_event']) ?>
                </h2>
                <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-top: 15px;">
                    <span style="color: #666; font-size: 14px;">
                        <i class="fas fa-calendar" style="color: #7c3aed;"></i> 
                        <?= date('d F Y', strtotime($event['tanggal_event'])) ?>
                    </span>
                    <span style="color: #666; font-size: 14px;">
                        <i class="fas fa-map-marker-alt" style="color: #dc3545;"></i> 
                        <?= htmlspecialchars($event['lokasi']) ?>
                    </span>
                    <span style="color: #666; font-size: 14px;">
                        <i class="fas fa-tag" style="color: #ffc107;"></i> 
                        <?= htmlspecialchars($event['kategori']) ?>
                    </span>
                </div>
            </div>

            <!-- Event Description -->
            <div style="margin-bottom: 30px;">
                <h4 style="color: var(--text-color); margin-bottom: 15px; font-size: 18px;">
                    <i class="fas fa-info-circle"></i> Deskripsi Event
                </h4>
                <p style="color: var(--muted-color); line-height: 1.8; text-align: justify;">
                    <?= nl2br(htmlspecialchars($event['deskripsi'])) ?>
                </p>
            </div>

            <!-- Available Tickets -->
            <div style="margin-bottom: 30px;">
                <h4 style="color: var(--text-color); margin-bottom: 15px; font-size: 18px;">
                    <i class="fas fa-ticket-alt"></i> Tiket Tersedia
                </h4>
                
                <?php if (empty($tiket)): ?>
                    <div style="background: #fff3cd; padding: 20px; border-radius: 8px; border-left: 4px solid #ffc107;">
                        <i class="fas fa-exclamation-triangle" style="color: #856404;"></i>
                        <span style="color: #856404;">Belum ada tiket tersedia untuk event ini.</span>
                    </div>
                <?php else: ?>
                    <div style="display: grid; gap: 15px;">
                        <?php foreach ($tiket as $t): ?>
                            <div style="border: 1px solid var(--border-color); padding: 20px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; background: var(--card-bg);">
                                <div>
                                    <h5 style="color: var(--text-color); margin-bottom: 8px; font-size: 16px;">
                                        <?= htmlspecialchars($t['nama_tiket']) ?>
                                    </h5>
                                    <div style="color: var(--muted-color); font-size: 18px; font-weight: bold;">
                                        Rp <?= number_format($t['harga'], 0, ',', '.') ?>
                                    </div>
                                    <div style="color: var(--muted-color); font-size: 13px; margin-top: 5px;">
                                        <i class="fas fa-users"></i> Stok: <?= $t['stok'] ?> tiket
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 15px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                <?php if (!empty($tiket)): ?>
                    <a href="index.php?module=pemesanan&action=create&event_id=<?= $event['id'] ?>" 
                       class="btn-submit" 
                       style="text-decoration: none; flex: 1; text-align: center;">
                        <i class="fas fa-shopping-cart"></i> Pesan Tiket Sekarang
                    </a>
                <?php endif; ?>
                <a href="index.php?page=landing" 
                   class="btn-cancel" 
                   style="text-decoration: none; text-align: center;">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Sidebar - Event Summary -->
    <div>
        <div class="form-card" style="padding: 25px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; position: sticky; top: 20px;">
            <h4 style="margin-bottom: 20px; font-size: 18px; border-bottom: 1px solid rgba(255,255,255,0.3); padding-bottom: 15px;">
                <i class="fas fa-info-circle"></i> Informasi Event
            </h4>
            
            <div style="margin-bottom: 20px;">
                <div style="font-size: 13px; opacity: 0.9; margin-bottom: 5px;">Nama Event</div>
                <div style="font-weight: bold; font-size: 16px;"><?= htmlspecialchars($event['nama_event']) ?></div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="font-size: 13px; opacity: 0.9; margin-bottom: 5px;">
                    <i class="fas fa-calendar"></i> Tanggal
                </div>
                <div style="font-weight: bold;"><?= date('d F Y', strtotime($event['tanggal_event'])) ?></div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="font-size: 13px; opacity: 0.9; margin-bottom: 5px;">
                    <i class="fas fa-map-marker-alt"></i> Lokasi
                </div>
                <div style="font-weight: bold;"><?= htmlspecialchars($event['lokasi']) ?></div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="font-size: 13px; opacity: 0.9; margin-bottom: 5px;">
                    <i class="fas fa-tag"></i> Kategori
                </div>
                <div style="font-weight: bold;"><?= htmlspecialchars($event['kategori']) ?></div>
            </div>

            <?php if (!empty($tiket)): ?>
                <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.3);">
                    <div style="font-size: 13px; opacity: 0.9; margin-bottom: 10px;">Harga Mulai Dari</div>
                    <div style="font-size: 24px; font-weight: bold;">
                        Rp <?= number_format(min(array_column($tiket, 'harga')), 0, ',', '.') ?>
                    </div>
                </div>
            <?php endif; ?>

            <div style="margin-top: 25px; padding: 15px; background: rgba(255,255,255,0.1); border-radius: 8px; font-size: 13px; text-align: center;">
                <i class="fas fa-shield-alt"></i> Pembayaran Aman & Terpercaya
            </div>
        </div>
    </div>
</div>