<!-- Event Create Content -->
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-plus-circle"></i> Tambah Event Baru</h1>
</div>

<?php if (isset($_GET['message']) && $_GET['message'] === 'error_past_date'): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> <strong>Error!</strong> Tanggal event tidak boleh sebelum hari ini. Silakan pilih tanggal yang akan datang.
    </div>
<?php endif; ?>

<div class="form-card">
    <form method="POST" action="index.php?module=event&action=store" enctype="multipart/form-data">
        <div class="form-group">
            <label class="form-label">Nama Event <span style="color: red;">*</span></label>
            <input type="text" name="nama_event" class="form-control" placeholder="Contoh: Jazz Festival 2025" required>
        </div>

        <div class="form-group">
            <label class="form-label">Deskripsi Event</label>
            <textarea name="deskripsi" class="form-control" rows="4" placeholder="Deskripsi singkat tentang event..."></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Tanggal Event <span style="color: red;">*</span></label>
                <input type="date" name="tanggal_event" class="form-control" id="tanggalEvent" required>
                <small class="text-muted" style="color: #dc3545;">Tanggal harus hari ini atau setelahnya</small>
            </div>

            <div class="form-group">
                <label class="form-label">Lokasi <span style="color: red;">*</span></label>
                <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Jakarta Convention Center" required>
            </div>
        </div>

        <!-- Harga dan kapasitas sekarang ditangani di menu Tiket -->

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Kategori <span style="color: red;">*</span></label>
                <select name="kategori" class="form-select" required>
                    <option value="">Pilih Kategori</option>
                    <option value="Musik">Musik</option>
                    <option value="Konser">Konser</option>
                    <option value="Festival">Festival</option>
                    <option value="Konferensi">Konferensi</option>
                    <option value="Seminar">Seminar</option>
                    <option value="Olahraga">Olahraga</option>
                    <option value="Komedi">Komedi</option>
                    <option value="Teater">Teater</option>
                    <option value="Pameran">Pameran</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Status <span style="color: red;">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="Aktif">Aktif</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Dibatalkan">Dibatalkan</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Gambar Event</label>
            <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp" id="imageInput">
            <small class="text-muted">Format: JPG, PNG, GIF, WebP. Ukuran maksimal: 5MB</small>
            <div id="imagePreview" style="margin-top: 10px;"></div>
        </div>

        <div style="margin-top: 30px;">
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Simpan Event
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