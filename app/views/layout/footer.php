        </div>

        <?php
            // Hide footer on admin role for specific admin pages: dashboard, event, tiket, user (customer), pemesanan
            $currentModule = isset($module) ? $module : '';
            $hideFooterForAdmin = isset($_SESSION['admin_role']) && in_array($currentModule, ['dashboard', 'event', 'tiket', 'user', 'pemesanan']);
        ?>
        <?php if (! $hideFooterForAdmin): ?>
        <footer class="footer">
            <div class="container footer-content">
                <div class="row">
                    <div class="col-md-4 footer-section">
                        <h4>Konzert</h4>
                        <p style="color: var(--muted-color);">Platform tiket & event — temukan dan pesan tiket acara favorit Anda dengan mudah.</p>
                    </div>
                    <div class="col-md-4 footer-section">
                        <h4>Menu</h4>
                        <a href="index.php?page=landing">Home</a>
                        <a href="index.php?module=event&action=public">Events</a>
                        <a href="index.php?page=login">Login</a>
                    </div>
                    <div class="col-md-4 footer-section">
                        <h4>Hubungi Kami</h4>
                        <a href="#">support@konzert.example</a>
                        <a href="#">+62 812-3456-7890</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container text-center" style="color: var(--muted-color);">&copy; <?= date('Y') ?> Konzert. All rights reserved.</div>
            </div>
        </footer>
        <?php endif; ?>

    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>