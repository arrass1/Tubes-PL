<!-- Event Create Content -->
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-plus-circle"></i> Tambah Event Baru</h1>
</div>

<div class="form-card">
    <form method="POST" action="index.php?module=event&action=store">
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
                <input type="date" name="tanggal_event" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">Lokasi <span style="color: red;">*</span></label>
                <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Jakarta Convention Center" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Harga Tiket (Rp) <span style="color: red;">*</span></label>
                <input type="number" name="harga_tiket" class="form-control" placeholder="250000" min="0" step="1000" required>
            </div>

            <div class="form-group">
                <label class="form-label">Kapasitas (Orang) <span style="color: red;">*</span></label>
                <input type="number" name="kapasitas" class="form-control" placeholder="5000" min="1" required>
            </div>
        </div>

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