<!-- Pemesanan Create Content -->
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-plus-circle"></i> Buat Pesanan</h1>
</div>

<?php if (isset($_GET['error'])): ?>
    <?php if ($_GET['error'] === 'insufficient_stock'): ?>
        <div class="alert" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #dc3545;">
            <i class="fas fa-exclamation-circle"></i>
            <strong>Stok Tidak Cukup!</strong> Jumlah tiket yang Anda pesan melebihi stok yang tersedia. Silakan kurangi jumlah tiket.
        </div>
    <?php else: ?>
        <div class="alert" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #dc3545;">
            <i class="fas fa-exclamation-circle"></i>
            Terjadi kesalahan!
        </div>
    <?php endif; ?>
<?php endif; ?>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-top: 30px;">
    <!-- Main Form -->
    <div>
        <div class="form-card">
            <form method="POST" action="index.php?module=pemesanan&action=store">
                <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                
                <div class="form-group">
                    <label class="form-label">Nama Event</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($event['nama_event']) ?>" readonly>
                </div>

                <?php if (count($tickets) > 1): ?>
                    <!-- Jika ada lebih dari 1 tiket untuk event ini -->
                    <div class="form-group">
                        <label class="form-label" for="tiket_id">Pilih Tipe Tiket <span style="color: red;">*</span></label>
                        <select id="tiket_id" name="tiket_id" class="form-select" required onchange="updatePrice()">
                            <option value="">-- Pilih Tipe Tiket --</option>
                            <?php foreach ($tickets as $tiket): ?>
                                <option value="<?= $tiket['id'] ?>" 
                                        data-price="<?= $tiket['harga'] ?>"
                                        data-stok="<?= $tiket['stok'] ?>">
                                    <?= htmlspecialchars($tiket['nama_tiket']) ?> - Rp <?= number_format($tiket['harga'], 0, ',', '.') ?> (Stok: <?= $tiket['stok'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php else: ?>
                    <!-- Jika hanya 1 tiket, langsung set dengan harga otomatis terisi -->
                    <input type="hidden" name="tiket_id" value="<?= $tickets[0]['id'] ?>">
                    <input type="hidden" id="tiket_harga" value="<?= $tickets[0]['harga'] ?>">
                    <input type="hidden" id="tiket_stok" value="<?= $tickets[0]['stok'] ?>">
                    <div class="form-group">
                        <label class="form-label">Tipe Tiket</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($tickets[0]['nama_tiket']) ?>" readonly>
                    </div>
                    <div style="background-color: #f0f9ff; border: 1px solid #3b82f6; border-radius: 5px; padding: 12px; margin-bottom: 15px; color: #1e40af;">
                        <i class="fas fa-info-circle"></i> Stok Tersedia: <strong><?= $tickets[0]['stok'] ?></strong> tiket
                    </div>
                <?php endif; ?>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="jumlah_tiket">Jumlah Tiket <span style="color: red;">*</span></label>
                        <input type="number" id="jumlah_tiket" name="jumlah_tiket" class="form-control" min="1" value="1" placeholder="Masukkan jumlah tiket" required onchange="updatePrice()" oninput="updatePrice()">
                        <small id="stok_info" class="text-muted" style="color: #dc3545; font-weight: bold; display: none;"></small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Harga Per Tiket</label>
                        <input type="text" id="harga_tiket" class="form-control" readonly placeholder="Rp 0">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Total Harga</label>
                    <input type="text" id="total_harga" class="form-control" readonly placeholder="Rp 0" style="font-size: 18px; font-weight: bold; color: #10b981;">
                </div>

                <div style="margin-top: 30px;">
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <i class="fas fa-shopping-cart"></i> Lanjut ke Pembayaran
                    </button>
                    <a href="index.php?module=event&action=public" class="btn-cancel">
                        <i class="fas fa-arrow-left"></i> Kembali ke Event
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Sidebar - Event Preview -->
    <div>
        <div id="eventPreview" class="form-card" style="padding: 25px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; position: sticky; top: 20px;">
            <h4 style="margin-bottom: 20px; font-size: 18px; border-bottom: 1px solid rgba(255,255,255,0.3); padding-bottom: 15px;">
                <i class="fas fa-calendar-check"></i> Detail Event
            </h4>
            
            <div style="margin-bottom: 20px;">
                <div style="font-size: 13px; opacity: 0.9; margin-bottom: 5px;">Nama Event</div>
                <div style="font-weight: bold; font-size: 16px;"><?= htmlspecialchars($event['nama_event']) ?></div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="font-size: 13px; opacity: 0.9; margin-bottom: 5px;">
                    <i class="fas fa-calendar"></i> Tanggal
                </div>
                <div style="font-weight: bold;"><?= date('d M Y', strtotime($event['tanggal_event'])) ?></div>
            </div>

            <div style="margin-bottom: 20px;">
                <div style="font-size: 13px; opacity: 0.9; margin-bottom: 5px;">
                    <i class="fas fa-map-marker-alt"></i> Lokasi
                </div>
                <div style="font-weight: bold;"><?= htmlspecialchars($event['lokasi']) ?></div>
            </div>

            <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.3);">
                <div style="font-size: 13px; opacity: 0.9; margin-bottom: 10px;">Total Harga</div>
                <div id="preview_total" style="font-size: 24px; font-weight: bold;">Rp 0</div>
            </div>

            <div style="margin-top: 25px; padding: 15px; background: rgba(255,255,255,0.1); border-radius: 8px; font-size: 13px; text-align: center;">
                <i class="fas fa-shield-alt"></i> Pembayaran Aman & Terpercaya
            </div>
        </div>
    </div>
</div>

<script>
    function updatePrice() {
        const tiketSelect = document.getElementById('tiket_id');
        const jumlahInput = document.getElementById('jumlah_tiket');
        const hargaInput = document.getElementById('harga_tiket');
        const totalInput = document.getElementById('total_harga');
        const previewTotal = document.getElementById('preview_total');
        const stokInfo = document.getElementById('stok_info');
        const submitBtn = document.getElementById('submitBtn');
        
        let hargaPerTiket = 0;
        let maxStok = 0;
        
        // Jika ada select tiket (multiple tikets)
        if (tiketSelect && tiketSelect.value) {
            const selectedOption = tiketSelect.options[tiketSelect.selectedIndex];
            hargaPerTiket = parseInt(selectedOption.dataset.price) || 0;
            maxStok = parseInt(selectedOption.dataset.stok) || 0;
        } else if (tiketSelect && !tiketSelect.value) {
            // Jika tiket belum dipilih di select
            jumlahInput.value = 1;
            hargaInput.value = '';
            totalInput.value = '';
            previewTotal.textContent = 'Rp 0';
            return;
        } else {
            // Jika hanya 1 tiket, ambil dari hidden input
            const tiketHargaInput = document.getElementById('tiket_harga');
            const tiketStokInput = document.getElementById('tiket_stok');
            if (tiketHargaInput) {
                hargaPerTiket = parseInt(tiketHargaInput.value) || 0;
            }
            if (tiketStokInput) {
                maxStok = parseInt(tiketStokInput.value) || 0;
            }
        }
        
        const jumlah = parseInt(jumlahInput.value) || 1;
        
        // Validasi stok maksimal
        if (jumlah > maxStok) {
            stokInfo.style.display = 'block';
            stokInfo.textContent = '⚠️ Maksimal stok: ' + maxStok + ' tiket. Kurangi jumlah pemesanan.';
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.6';
            submitBtn.style.cursor = 'not-allowed';
        } else {
            stokInfo.style.display = 'none';
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';
        }
        
        const total = hargaPerTiket * jumlah;

        hargaInput.value = 'Rp ' + hargaPerTiket.toLocaleString('id-ID');
        totalInput.value = 'Rp ' + total.toLocaleString('id-ID');
        if (previewTotal) {
            previewTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updatePrice();
    });
</script>