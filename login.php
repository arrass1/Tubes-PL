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
    <title>Login - EventHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="login-page">
    <div class="login-container">
        <a href="landing.php" class="back-to-landing" style="position: absolute; top: 20px; left: 20px;">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        <div class="login-header">
            <h1><i class="fas fa-calendar-alt"></i> EventHub</h1>
            <p>Platform Tiket & Event Terbaik</p>
        </div>

        <div class="login-body">
            <!-- Role Toggle -->
            <div class="role-toggle">
                <button type="button" class="role-btn active" id="roleUser" onclick="setRole('user')">
                    <i class="fas fa-user"></i> User
                </button>
                <button type="button" class="role-btn" id="roleAdmin" onclick="setRole('admin')">
                    <i class="fas fa-shield-alt"></i> Admin
                </button>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php
                    if ($_GET['error'] === 'invalid') echo 'Email/Username atau password salah!';
                    elseif ($_GET['error'] === 'required') echo 'Silahkan lengkapi semua field!';
                    elseif ($_GET['error'] === 'registered') echo 'Email sudah terdaftar!';
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    Registrasi berhasil! Silahkan login.
                </div>
            <?php endif; ?>

            <!-- User Login Form -->
            <form method="POST" action="index.php?action=login" id="userForm" style="display: block;">
                <input type="hidden" name="role" value="user">

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email Anda" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label" for="remember">
                        Ingat saya
                    </label>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Masuk sebagai User
                </button>
            </form>

            <!-- Admin Login Form -->
            <form method="POST" action="index.php?action=login" id="adminForm" style="display: none;">
                <input type="hidden" name="role" value="admin">

                <div class="form-group">
                    <label class="form-label" for="adminUsername">Username</label>
                    <input type="text" class="form-control" id="adminUsername" name="username" placeholder="Masukkan username" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="adminPassword">Password</label>
                    <input type="password" class="form-control" id="adminPassword" name="password" placeholder="Masukkan password" required>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Masuk sebagai Admin
                </button>
            </form>

            <div class="login-footer">
                <p>Belum punya akun?</p>
                <a href="index.php?page=register">
                    <i class="fas fa-user-plus"></i> Daftar di sini
                </a>
            </div>
        </div>
    </div>

    <script>
        function setRole(role) {
            const userForm = document.getElementById('userForm');
            const adminForm = document.getElementById('adminForm');
            const roleUserBtn = document.getElementById('roleUser');
            const roleAdminBtn = document.getElementById('roleAdmin');

            if (role === 'user') {
                userForm.style.display = 'block';
                adminForm.style.display = 'none';
                roleUserBtn.classList.add('active');
                roleAdminBtn.classList.remove('active');
            } else {
                userForm.style.display = 'none';
                adminForm.style.display = 'block';
                roleUserBtn.classList.remove('active');
                roleAdminBtn.classList.add('active');
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
