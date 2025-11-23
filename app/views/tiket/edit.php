<!-- Tiket Edit Content -->
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-edit"></i> Edit Tiket</h1>
</div>

<div class="form-card">
    <form method="POST" action="index.php?module=tiket&action=update">
        <input type="hidden" name="id" value="<?= $tiket['id'] ?>">

        <div class="form-group">
            <label for="event_id" class="form-label">Event <span style="color: red;">*</span></label>
            <select id="event_id" name="event_id" class="form-select" required>
                <option value="">-- Pilih Event --</option>
                <?php foreach ($events as $event): ?>
                    <option value="<?= $event['id'] ?>" <?= $event['id'] == $tiket['event_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($event['nama_event']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="nama_tiket" class="form-label">Nama Tiket <span style="color: red;">*</span></label>
            <input type="text" id="nama_tiket" name="nama_tiket" class="form-control" value="<?= htmlspecialchars($tiket['nama_tiket']) ?>" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="harga" class="form-label">Harga <span style="color: red;">*</span></label>
                <input type="number" id="harga" name="harga" class="form-control" value="<?= $tiket['harga'] ?>" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="stok" class="form-label">Stok <span style="color: red;">*</span></label>
                <input type="number" id="stok" name="stok" class="form-control" value="<?= $tiket['stok'] ?>" required>
            </div>
        </div>

        <div style="margin-top: 30px;">
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Perbarui Tiket
            </button>
            <a href="index.php?module=tiket" class="btn-cancel">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>
