<!-- Event Edit Content -->
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-edit"></i> Edit Event</h1>
</div>

<?php if (isset($_GET['message']) && $_GET['message'] === 'error_past_date'): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> <strong>Error!</strong> Tanggal event tidak boleh sebelum hari ini. Silakan pilih tanggal yang akan datang.
    </div>
<?php endif; ?>

<div class="form-card">
    <form method="POST" action="index.php?module=event&action=update" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $event['id'] ?>">
        
        <div class="form-group">
            <label class="form-label">Nama Event <span style="color: red;">*</span></label>
            <input type="text" name="nama_event" class="form-control" placeholder="Contoh: Jazz Festival 2025" value="<?= htmlspecialchars($event['nama_event']) ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label">Deskripsi Event</label>
            <textarea name="deskripsi" class="form-control" rows="4" placeholder="Deskripsi singkat tentang event..."><?= htmlspecialchars($event['deskripsi'] ?? '') ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Tanggal Event <span style="color: red;">*</span></label>
                <input type="date" name="tanggal_event" class="form-control" id="tanggalEvent" value="<?= $event['tanggal_event'] ?>" required>
                <small class="text-muted text-danger">Tanggal harus hari ini atau setelahnya</small>
            </div>

            <div class="form-group">
                <label class="form-label">Lokasi <span style="color: red;">*</span></label>
                <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Jakarta Convention Center" value="<?= htmlspecialchars($event['lokasi']) ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Kategori <span style="color: red;">*</span></label>
                <select name="kategori" class="form-select" required>
                    <option value="">Pilih Kategori</option>
                    <option value="Musik" <?= $event['kategori'] == 'Musik' ? 'selected' : '' ?>>Musik</option>
                    <option value="Konser" <?= $event['kategori'] == 'Konser' ? 'selected' : '' ?>>Konser</option>
                    <option value="Festival" <?= $event['kategori'] == 'Festival' ? 'selected' : '' ?>>Festival</option>
                    <option value="Konferensi" <?= $event['kategori'] == 'Konferensi' ? 'selected' : '' ?>>Konferensi</option>
                    <option value="Seminar" <?= $event['kategori'] == 'Seminar' ? 'selected' : '' ?>>Seminar</option>
                    <option value="Olahraga" <?= $event['kategori'] == 'Olahraga' ? 'selected' : '' ?>>Olahraga</option>
                    <option value="Komedi" <?= $event['kategori'] == 'Komedi' ? 'selected' : '' ?>>Komedi</option>
                    <option value="Teater" <?= $event['kategori'] == 'Teater' ? 'selected' : '' ?>>Teater</option>
                    <option value="Pameran" <?= $event['kategori'] == 'Pameran' ? 'selected' : '' ?>>Pameran</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Status <span style="color: red;">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="Aktif" <?= $event['status'] == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                    <option value="Selesai" <?= $event['status'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                    <option value="Dibatalkan" <?= $event['status'] == 'Dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Gambar Event</label>
            <?php if ($event['image']): ?>
                <div style="margin-bottom: 15px;">
                    <p><strong>Gambar saat ini:</strong></p>
                    <img src="<?= htmlspecialchars($event['image']) ?>" style="max-width: 200px; max-height: 200px; border-radius: 5px;">
                </div>
            <?php endif; ?>
            <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp" id="imageInput">
            <small class="text-muted">Format: JPG, PNG, GIF, WebP. Ukuran maksimal: 5MB (Biarkan kosong jika tidak ingin mengubah)</small>
            <div id="imagePreview" style="margin-top: 10px;"></div>
        </div>

        <div style="margin-top: 30px;">
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Update Event
            </button>
            <a href="index.php?module=event" class="btn-cancel">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>

<script>
// Set minimum date to today
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    const tanggalEventInput = document.getElementById('tanggalEvent');
    tanggalEventInput.setAttribute('min', today);
});

document.getElementById('imageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';

    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const img = document.createElement('img');
            img.src = event.target.result;
            img.style.maxWidth = '200px';
            img.style.maxHeight = '200px';
            img.style.borderRadius = '5px';
            preview.appendChild(img);
        };
        reader.readAsDataURL(file);
    }
});
</script>
