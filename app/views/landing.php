<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get some events to display (you can modify this to fetch from database)
require_once 'config/database.php';
require_once 'app/models/EventModel.php';
require_once 'app/models/TiketModel.php';

$database = new Database();
$db = $database->getConnection();
$eventModel = new EventModel($db);
$tiketModel = new TiketModel($db);

// Pagination setup
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$itemsPerPage = 12;

// Get search keyword
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Get selected category
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Get all active events based on filters
$allEvents = [];
if ($search) {
    // Search events
    $searchKeyword = '%' . $search . '%';
    $allEvents = $db->query(
        "SELECT * FROM events 
         WHERE status = 'Aktif' 
         AND tanggal_event >= CURDATE()
         AND (nama_event LIKE :search OR deskripsi LIKE :search OR kategori LIKE :search)
         ORDER BY tanggal_event ASC"
    );
    $allEvents->execute([':search' => $searchKeyword]);
    $allEvents = $allEvents->fetchAll(PDO::FETCH_ASSOC);
} elseif ($category) {
    // Filter by category
    $allEvents = $db->query(
        "SELECT * FROM events 
         WHERE status = 'Aktif' 
         AND tanggal_event >= CURDATE()
         AND kategori = :category
         ORDER BY tanggal_event ASC"
    );
    $allEvents->execute([':category' => $category]);
    $allEvents = $allEvents->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Get all active events
    $allEvents = $db->query(
        "SELECT * FROM events 
         WHERE status = 'Aktif' 
         AND tanggal_event >= CURDATE()
         ORDER BY tanggal_event ASC"
    );
    $allEvents = $allEvents->fetchAll(PDO::FETCH_ASSOC);
}

// Calculate pagination
$totalEvents = count($allEvents);
$totalPages = ceil($totalEvents / $itemsPerPage);
if ($currentPage > $totalPages && $totalPages > 0) {
    $currentPage = $totalPages;
}
if ($currentPage < 1) {
    $currentPage = 1;
}

// Get events for current page
$offset = ($currentPage - 1) * $itemsPerPage;
$upcomingEvents = array_slice($allEvents, $offset, $itemsPerPage);

// Get all categories for filter dropdown
$categoriesQuery = $db->query("SELECT DISTINCT kategori FROM events WHERE status = 'Aktif' AND tanggal_event >= CURDATE() ORDER BY kategori");
$categories = $categoriesQuery->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konzert - Platform Event & Tiket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>assets/css/style.css" rel="stylesheet">
</head>

<body style="margin: 0; padding: 0;">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg"
        style="background:var(--card-bg); box-shadow: 0 6px 24px var(--shadow-color); margin: 0; padding: 0.5rem 0;">
        <div class="container">
            <a class="navbar-brand" href="index.php?page=landing">
                <i class="fas fa-compact-disc" style="color: #7c3aed;"></i>
                <span style="color: var(--text-color);">Konzert</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <!-- MENU KIRI -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" style="color: var(--text-color);" href="index.php?page=landing">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="color: var(--text-color);"
                            href="index.php?module=event&action=public">Events</a>
                    </li>
                </ul>

                <!-- MENU KANAN -->
                <div class="ms-auto d-flex align-items-center">
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- User Login Info -->
                    <span class="me-3" style="color: var(--text-color); font-size: 14px; display: inline-block;">
                        <i class="fas fa-user-circle"></i>
                        <?= htmlspecialchars($_SESSION['user_name']) ?>
                    </span>

                    <a href="index.php?module=pemesanan&action=my_orders" class="btn btn-sm btn-outline-secondary me-2">
                        <i class="fas fa-receipt"></i> Pesanan Saya
                    </a>

                    <a href="index.php?action=logout" class="btn btn-sm btn-outline-secondary"
                        onclick="return confirm('Yakin ingin logout?');">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <?php else: ?>
                    <!-- Not Login -->
                    <a href="index.php?page=login" class="btn btn-sm btn-outline-secondary me-2">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>

                    <a href="index.php?page=register" class="btn btn-sm btn-primary">
                        <i class="fas fa-user-plus"></i> Daftar
                    </a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Temukan Event Terbaik</h1>
            <p>Platform terpercaya untuk menemukan, membeli, dan menikmati event impian Anda</p>
            <div class="hero-buttons">
                <?php if (isset($_SESSION['user_id'])): ?>
                <a href="index.php?module=event&action=public" class="btn-cta-primary">
                    <i class="fas fa-ticket-alt"></i> Pesan Tiket Sekarang
                </a>
                <?php else: ?>
                <a href="index.php?page=register" class="btn-cta-primary">
                    <i class="fas fa-ticket-alt"></i> Beli Tiket
                </a>
                <?php endif; ?>
                <a href="#features" class="btn-cta-secondary">
                    <i class="fas fa-arrow-down"></i> Pelajari Lebih
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <h2 class="section-title">Mengapa Memilih Konzert?</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-search"></i>
                        <h3>Cari Event Mudah</h3>
                        <p>Temukan ribuan event dari berbagai kategori dengan mudah dan cepat</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-lock"></i>
                        <h3>Pembayaran Aman</h3>
                        <p>Transaksi aman dan terpercaya dengan sistem keamanan terbaik</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-mobile-alt"></i>
                        <h3>Tiket Digital</h3>
                        <p>Terima tiket digital langsung ke perangkat Anda</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2>Jangan Lewatkan Event Impian Anda!</h2>
            <p>Bergabunglah dengan ribuan pengguna yang telah menikmati event terbaik bersama Konzert</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="container">
            <div class="row footer-content">
                <div class="col-md-3">
                    <div class="footer-section">
                        <h4>Konzert</h4>
                        <p style="color: var(--muted-color); font-size: 14px;">Platform terpercaya untuk event dan tiket
                            terbaik</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footer-section">
                        <h4>Navigasi</h4>
                        <a href="#events">Events</a>
                        <a href="#features">Fitur</a>
                        <a href="#">Tentang Kami</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footer-section">
                        <h4>Bantuan</h4>
                        <a href="#">FAQ</a>
                        <a href="#">Support</a>
                        <a href="#">Kebijakan Privasi</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footer-section">
                        <h4>Ikuti Kami</h4>
                        <a href="#"><i class="fab fa-facebook"></i> Facebook</a>
                        <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
                        <a href="#"><i class="fab fa-twitter"></i> Twitter</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Konzert. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>