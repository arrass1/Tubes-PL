<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - Event Management' : 'Event Management' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Top Navbar -->
    <nav class="navbar-top">
        <div class="navbar-container">
            <div class="navbar-brand">
                <i class="fas fa-calendar-alt"></i> EventHub
            </div>
            
            <!-- Admin Menu (only for admin) -->
            <?php if (isset($_SESSION['admin_role'])): ?>
            <div class="navbar-menu">
                <a href="index.php?module=dashboard" class="nav-menu-link <?= ($module === 'dashboard' ? 'active' : '') ?>">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <a href="index.php?module=event" class="nav-menu-link <?= ($module === 'event' ? 'active' : '') ?>">
                    <i class="fas fa-calendar"></i> Event
                </a>
                <a href="index.php?module=tiket" class="nav-menu-link <?= ($module === 'tiket' ? 'active' : '') ?>">
                    <i class="fas fa-ticket-alt"></i> Tiket
                </a>
                <a href="index.php?module=user" class="nav-menu-link <?= ($module === 'user' ? 'active' : '') ?>">
                    <i class="fas fa-users"></i> Customer
                </a>
                <a href="index.php?module=pemesanan" class="nav-menu-link <?= ($module === 'pemesanan' ? 'active' : '') ?>">
                    <i class="fas fa-shopping-cart"></i> Pesanan
                </a>
            </div>
            <?php elseif (isset($_SESSION['user_id'])): ?>
            <!-- User Menu (only for regular users) -->
            <div class="navbar-menu">
                <a href="landing.php" class="nav-menu-link">
                    <i class="fas fa-home"></i> Home
                </a>
                <a href="index.php?module=pemesanan&action=my_orders" class="nav-menu-link <?= ($module === 'pemesanan' ? 'active' : '') ?>">
                    <i class="fas fa-receipt"></i> Pesanan Saya
                </a>
            </div>
            <?php endif; ?>

            <!-- Right Side: User Info & Logout -->
            <div class="navbar-user">
                <?php if (isset($_SESSION['admin_role']) || isset($_SESSION['user_id'])): ?>
                    <div class="user-info">
                        <i class="fas fa-user-circle"></i>
                        <span>
                            <?php if (isset($_SESSION['admin_role'])): ?>
                                <?= htmlspecialchars($_SESSION['admin_name']) ?>
                            <?php else: ?>
                                <?= htmlspecialchars($_SESSION['user_name']) ?>
                            <?php endif; ?>
                        </span>
                    </div>
                    <a href="index.php?action=logout" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="main-content-wrapper">
        <div class="main-content">
