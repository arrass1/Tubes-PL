<!-- Pemesanan Create Content -->
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-plus-circle"></i> Buat Pesanan Baru</h1>
</div>

<?php if (isset($_GET['error'])): ?>
    <div class="alert" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #dc3545;">
        <i class="fas fa-exclamation-circle"></i>
        Terjadi kesalahan!
    </div>
<?php endif; ?>

<div class="form-card">
    <form method="POST" action="index.php?module=pemesanan&action=store">
        <div class="form-group">
            <label class="form-label" for="event_id">Pilih Event <span style="color: red;">*</span></label>
            <select id="event_id" name="event_id" class="form-select" required onchange="updatePrice()">
                <option value="">-- Pilih Event --</option>
                <?php foreach ($events as $event): ?>
                    <option value="<?= $event['id'] ?>" data-price="<?= $event['harga_tiket'] ?>">
                        <?= htmlspecialchars($event['nama_event']) ?> - Rp <?= number_format($event['harga_tiket'], 0, ',', '.') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="jumlah_tiket">Jumlah Tiket <span style="color: red;">*</span></label>
                <input type="number" id="jumlah_tiket" name="jumlah_tiket" class="form-control" min="1" placeholder="Masukkan jumlah tiket" required onchange="updatePrice()" oninput="updatePrice()">
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
            <button type="submit" class="btn-submit">
                <i class="fas fa-shopping-cart"></i> Buat Pesanan
            </button>
            <a href="index.php?module=pemesanan&action=my_orders" class="btn-cancel">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>

<script>
    function updatePrice() {
        const eventSelect = document.getElementById('event_id');
        const jumlahInput = document.getElementById('jumlah_tiket');
        const hargaInput = document.getElementById('harga_tiket');
        const totalInput = document.getElementById('total_harga');

        const selectedOption = eventSelect.options[eventSelect.selectedIndex];
        const hargaPerTiket = parseInt(selectedOption.dataset.price) || 0;
        const jumlah = parseInt(jumlahInput.value) || 0;
        const total = hargaPerTiket * jumlah;

        hargaInput.value = 'Rp ' + hargaPerTiket.toLocaleString('id-ID');
        totalInput.value = 'Rp ' + total.toLocaleString('id-ID');
    }
</script>
