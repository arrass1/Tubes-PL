<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - Event Management' : 'Event Management' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <?php
        $cssPath = __DIR__ . '/../../../assets/css/style.css';
        $cssVer = file_exists($cssPath) ? filemtime($cssPath) : time();
    ?>
    <link href="assets/css/style.css?v=<?php echo $cssVer; ?>" rel="stylesheet">
</head>

<body style="margin: 0; padding: 0;">
    <!-- Top Navbar (Bootstrap) -->
    <nav class="navbar navbar-expand-lg" style="background:var(--card-bg); box-shadow: 0 6px 24px var(--shadow-color); margin: 0; padding: 0.5rem 0;">
        <div class="container">
            <a class="navbar-brand" href="index.php?page=landing">
                <i class="fas fa-compact-disc" style="color: #7c3aed;"></i> <span style="color: var(--text-color);">Konzert</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <?php if (isset($_SESSION['admin_role'])): ?>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link <?= ($module === 'dashboard' ? 'active' : '') ?>"
                            style="color: var(--text-color);" href="index.php?module=dashboard">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($module === 'event' ? 'active' : '') ?>"
                            style="color: var(--text-color);" href="index.php?module=event">Event</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($module === 'tiket' ? 'active' : '') ?>"
                            style="color: var(--text-color);" href="index.php?module=tiket">Tiket</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($module === 'user' ? 'active' : '') ?>"
                            style="color: var(--text-color);" href="index.php?module=user">Customer</a></li>
                    <li class="nav-item"><a class="nav-link <?= ($module === 'pemesanan' ? 'active' : '') ?>"
                            style="color: var(--text-color);" href="index.php?module=pemesanan">Pesanan</a></li>
                </ul>
                <?php else: ?>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" style="color: var(--text-color);" href="index.php?page=landing">Home</a>
                    </li>
                        <li class="nav-item"><a class="nav-link" style="color: var(--text-color);"
                            href="index.php?module=event&action=public">Events</a></li>
                </ul>
                <?php endif; ?>

                <div class="d-flex align-items-center">
                    <?php if (isset($_SESSION['user_id']) || isset($_SESSION['admin_role'])): ?>
                    <div class="me-3 d-flex align-items-center" style="color: var(--text-color);">
                        <i class="fas fa-user-circle fa-lg" style="margin-right:8px;"></i>
                        <span>
                            <?= isset($_SESSION['admin_role']) ? htmlspecialchars($_SESSION['admin_name']) : htmlspecialchars($_SESSION['user_name'] ?? '') ?>
                        </span>
                    </div>
                    <a href="index.php?action=logout" class="btn btn-sm btn-outline-secondary"
                        onclick="return confirm('Yakin ingin logout?');">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <?php else: ?>
                    <a href="index.php?page=login" class="btn btn-sm btn-outline-secondary me-2">Login</a>
                    <a href="index.php?page=register" class="btn btn-sm btn-primary">Daftar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="main-content-wrapper">
        <div class="main-content">