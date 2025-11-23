<!-- Tiket Create Content -->
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-plus-circle"></i> Tambah Tiket Baru</h1>
</div>

<div class="form-card">
    <form method="POST" action="index.php?module=tiket&action=store">
        <div class="form-group">
            <label for="event_id" class="form-label">Event <span style="color: red;">*</span></label>
            <select id="event_id" name="event_id" class="form-select" required>
                <option value="">-- Pilih Event --</option>
                <?php foreach ($events as $event): ?>
                    <option value="<?= $event['id'] ?>">
                        <?= htmlspecialchars($event['nama_event']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="nama_tiket" class="form-label">Nama Tiket <span style="color: red;">*</span></label>
            <input type="text" id="nama_tiket" name="nama_tiket" class="form-control" placeholder="Contoh: VIP, Regular, Student" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="harga" class="form-label">Harga <span style="color: red;">*</span></label>
                <input type="number" id="harga" name="harga" class="form-control" placeholder="0" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="stok" class="form-label">Stok <span style="color: red;">*</span></label>
                <input type="number" id="stok" name="stok" class="form-control" placeholder="0" required>
            </div>
        </div>

        <div style="margin-top: 30px;">
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Simpan Tiket
            </button>
            <a href="index.php?module=tiket" class="btn-cancel">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>
