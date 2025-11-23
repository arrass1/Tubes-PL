<!-- User Create Content -->
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-plus-circle"></i> Tambah Customer Baru</h1>
</div>

        <div class="form-card">
            <form method="POST" action="index.php?module=user&action=store">
                <div class="form-group">
                    <label for="nama" class="form-label">Nama Lengkap <span style="color: red;">*</span></label>
                    <input type="text" id="nama" name="nama" class="form-control" placeholder="Contoh: Budi Santoso" required>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email <span style="color: red;">*</span></label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="contoh@email.com" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="password" class="form-label">Password <span style="color: red;">*</span></label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>

                    <div class="form-group">
                        <label for="no_telepon" class="form-label">No Telepon</label>
                        <input type="text" id="no_telepon" name="no_telepon" class="form-control" placeholder="081234567890">
                    </div>
                </div>

                <div class="form-group">
                    <label for="role" class="form-label">Role <span style="color: red;">*</span></label>
                    <select id="role" name="role" class="form-select" required>
                        <option value="customer">Customer</option>
                        <option value="member">Member</option>
                    </select>
                </div>

                <div style="margin-top: 30px;">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Simpan Customer
                    </button>
                    <a href="index.php?module=user" class="btn-cancel">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
