<!-- User Edit Content -->
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-edit"></i> Edit Customer</h1>
</div>

        <div class="form-card">
            <form method="POST" action="index.php?module=user&action=update">
                <input type="hidden" name="id" value="<?= $user['user_id'] ?>">

                <div class="form-group">
                    <label for="nama" class="form-label">Nama Lengkap <span style="color: red;">*</span></label>
                    <input type="text" id="nama" name="nama" class="form-control" value="<?= htmlspecialchars($user['nama']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email <span style="color: red;">*</span></label>
                    <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="no_telepon" class="form-label">No Telepon</label>
                        <input type="text" id="no_telepon" name="no_telepon" class="form-control" value="<?= htmlspecialchars($user['no_telepon'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="role" class="form-label">Role <span style="color: red;">*</span></label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="customer" <?= $user['role'] === 'customer' ? 'selected' : '' ?>>Customer</option>
                            <option value="member" <?= $user['role'] === 'member' ? 'selected' : '' ?>>Member</option>
                        </select>
                    </div>
                </div>

                <div style="margin-top: 30px;">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Perbarui Customer
                    </button>
                    <a href="index.php?module=user" class="btn-cancel">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
