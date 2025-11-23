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
    <title>EventHub - Platform Event & Tiket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-calendar-alt"></i> EventHub
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#events">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Kontak</a>
                    </li>
                </ul>
                <div class="ms-3">
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- User Login Info -->
                    <span class="me-3" style="color: #666; font-size: 14px;">
                        <i class="fas fa-user-circle"></i>
                        <?= htmlspecialchars($_SESSION['user_name']) ?>
                    </span>
                    <a href="index.php?module=pemesanan&action=my_orders" class="btn-login me-2"
                        style="display: inline-block;">
                        <i class="fas fa-receipt"></i> Pesanan Saya
                    </a>
                    <a href="index.php?action=logout" class="btn-register" style="display: inline-block;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <?php else: ?>
                    <!-- Not Login -->
                    <a href="index.php?page=login" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                    <a href="index.php?page=register" class="btn-register">
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
                <a href="#events" class="btn-cta-primary">
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
            <h2 class="section-title">Mengapa Memilih EventHub?</h2>
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
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-headset"></i>
                        <h3>Support 24/7</h3>
                        <p>Tim support kami siap membantu Anda kapan saja</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-star"></i>
                        <h3>Rating & Review</h3>
                        <p>Lihat rating dan ulasan dari pengguna lain</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-gift"></i>
                        <h3>Promo Spesial</h3>
                        <p>Dapatkan diskon dan penawaran eksklusif</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Events Section -->
    <section class="events" id="events">
        <div class="container">
            <h2 class="section-title">Event Populer</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="event-card">
                        <div class="event-image">
                            <i class="fas fa-music"></i>
                        </div>
                        <div class="event-info">
                            <h4>Tech Conference 2025</h4>
                            <div class="event-date"><i class="fas fa-calendar"></i> 10 Mar 2025</div>
                            <div class="event-location"><i class="fas fa-map-marker-alt"></i> Bali Convention Center
                            </div>
                            <div class="event-price"><i class="fas fa-tag"></i> Rp 500.000</div>
                            <?php if (isset($_SESSION['user_id'])): ?>
                            <button class="btn-order"
                                onclick="window.location.href='index.php?module=pemesanan&action=create'">
                                <i class="fas fa-ticket-alt"></i> Pesan Sekarang
                            </button>
                            <?php else: ?>
                            <button class="btn-order" onclick="window.location.href='index.php?page=login'">
                                <i class="fas fa-ticket-alt"></i> Login untuk Pesan
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="event-card">
                        <div class="event-image">
                            <i class="fas fa-guitar"></i>
                        </div>
                        <div class="event-info">
                            <h4>Rock Concert - The Legends</h4>
                            <div class="event-date"><i class="fas fa-calendar"></i> 20 Feb 2025</div>
                            <div class="event-location"><i class="fas fa-map-marker-alt"></i> Gelora Bung Karno</div>
                            <div class="event-price"><i class="fas fa-tag"></i> Rp 350.000</div>

                            <?php if (isset($_SESSION['user_id'])): ?>
                            <button class="btn-order"
                                onclick="window.location.href='index.php?module=pemesanan&action=create'">
                                <i class="fas fa-ticket-alt"></i> Pesan Sekarang
                            </button>
                            <?php else: ?>
                            <button class="btn-order" onclick="window.location.href='index.php?page=login'">
                                <i class="fas fa-ticket-alt"></i> Login untuk Pesan
                            </button>
                            <?php endif; ?>

                        </div> <!-- TUTUP event-info -->
                    </div> <!-- TUTUP event-card -->
                </div>
                <div class="col-md-4">
                    <div class="event-card">
                        <div class="event-image">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <div class="event-info">
                            <h4>Food Festival</h4>
                            <div class="event-date"><i class="fas fa-calendar"></i> 25 Jan 2025</div>
                            <div class="event-location"><i class="fas fa-map-marker-alt"></i> Senayan City</div>
                            <div class="event-price"><i class="fas fa-tag"></i> Rp 50.000</div>
                            <?php if (isset($_SESSION['user_id'])): ?>
                            <button class="btn-order"
                                onclick="window.location.href='index.php?module=pemesanan&action=create'">
                                <i class="fas fa-ticket-alt"></i> Pesan Sekarang
                            </button>
                            <?php else: ?>
                            <button class="btn-order" onclick="window.location.href='index.php?page=login'">
                                <i class="fas fa-ticket-alt"></i> Login untuk Pesan
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2>Jangan Lewatkan Event Impian Anda!</h2>
            <p>Bergabunglah dengan ribuan pengguna yang telah menikmati event terbaik bersama EventHub</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="container">
            <div class="row footer-content">
                <div class="col-md-3">
                    <div class="footer-section">
                        <h4>EventHub</h4>
                        <p style="color: #999; font-size: 14px;">Platform terpercaya untuk event dan tiket terbaik</p>
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
                <p>&copy; 2025 EventHub. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>