<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - EventHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="register-page">
    <div class="register-container">
        <a href="landing.php" class="back-to-landing" style="position: absolute; top: 20px; left: 20px;">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        <div class="register-header">
            <h1><i class="fas fa-calendar-alt"></i> EventHub</h1>
            <p>Daftar Akun Baru</p>
        </div>

        <div class="register-body">
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php
                    if ($_GET['error'] === 'email_exists') echo 'Email sudah terdaftar!';
                    elseif ($_GET['error'] === 'required') echo 'Silahkan lengkapi semua field!';
                    elseif ($_GET['error'] === 'invalid_email') echo 'Format email tidak valid!';
                    ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="index.php?action=register">
                <div class="form-group">
                    <label class="form-label" for="nama">Nama Lengkap <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email <span style="color: red;">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="password">Password <span style="color: red;">*</span></label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 6 karakter" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="confirm_password">Konfirmasi Password <span style="color: red;">*</span></label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Ulangi password" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="no_telepon">No. Telepon</label>
                    <input type="text" class="form-control" id="no_telepon" name="no_telepon" placeholder="Masukkan no. telepon (opsional)">
                </div>

                <div class="form-group">
                    <label class="form-label" for="role">Tipe Akun <span style="color: red;">*</span></label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="">-- Pilih Tipe Akun --</option>
                        <option value="customer">Customer Biasa</option>
                        <option value="member">Member Premium</option>
                    </select>
                </div>

                <button type="submit" class="btn-register">
                    <i class="fas fa-user-plus"></i> Daftar Akun
                </button>

                <div class="register-footer">
                    <p>Sudah punya akun?</p>
                    <a href="index.php?page=login">
                        <i class="fas fa-sign-in-alt"></i> Login di sini
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
