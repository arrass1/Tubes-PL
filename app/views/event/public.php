<!-- Public Event Listing for Users -->
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-calendar-day"></i> Semua Event</h1>
</div>

<!-- Category Filter -->
<div class="filter-section" style="margin-bottom: 30px; padding: 20px; background-color: #f8f9fa; border-radius: 8px;">
    <h5 style="margin-bottom: 15px;"><i class="fas fa-filter"></i> Filter Kategori</h5>
    <div class="category-filter-wrapper">
        <a href="index.php?module=event&action=public"
            class="category-btn <?php echo empty($_GET['kategori']) ? 'active' : ''; ?>"
            style="display: inline-block; padding: 10px 20px; margin-right: 8px; margin-bottom: 10px; background-color: <?php echo empty($_GET['kategori']) ? '#007bff' : '#e9ecef'; ?>; color: <?php echo empty($_GET['kategori']) ? '#fff' : '#495057'; ?>; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; transition: all 0.3s ease;">
            Semua
        </a>
        <?php foreach ($categories as $category): ?>
        <a href="index.php?module=event&action=public&kategori=<?php echo urlencode($category); ?>"
            class="category-btn <?php echo (isset($_GET['kategori']) && $_GET['kategori'] === $category) ? 'active' : ''; ?>"
            style="display: inline-block; padding: 10px 20px; margin-right: 8px; margin-bottom: 10px; background-color: <?php echo (isset($_GET['kategori']) && $_GET['kategori'] === $category) ? '#007bff' : '#e9ecef'; ?>; color: <?php echo (isset($_GET['kategori']) && $_GET['kategori'] === $category) ? '#fff' : '#495057'; ?>; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; transition: all 0.3s ease;">
            <?php echo htmlspecialchars($category); ?>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<?php if (empty($events)): ?>
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i> Tidak ada event tersedia saat ini.
</div>
<?php else: ?>
<div class="row">
    <?php foreach ($events as $event): ?>
    <div class="col-md-4 mb-4">
        <div class="card event-card">
            <?php
                        $img = isset($event['image']) && !empty($event['image']) ? $event['image'] : null;
                        if ($img):
                    ?>
            <img src="<?= htmlspecialchars($img) ?>" class="card-img-top"
                alt="<?= htmlspecialchars($event['nama_event']) ?>">
            <?php else: ?>
            <img src="https://via.placeholder.com/600x300?text=Event+<?= urlencode($event['nama_event']) ?>"
                class="card-img-top" alt="<?= htmlspecialchars($event['nama_event']) ?>">
            <?php endif; ?>
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($event['nama_event']) ?></h5>
                <p class="card-text" style="margin-bottom:6px;"><i class="fas fa-map-marker-alt"></i>
                    <?= htmlspecialchars($event['lokasi']) ?></p>
                <p class="card-text" style="margin-bottom:6px;"><i class="fas fa-calendar"></i>
                    <?= date('d M Y', strtotime($event['tanggal_event'])) ?></p>
                <p class="card-text">
                    <strong>Harga: </strong>
                    <?php if ($event['min_price'] !== null): ?>
                    Rp <?= number_format($event['min_price'], 0, ',', '.') ?>
                    <?php else: ?>
                    <span style="color:#777;">Belum tersedia</span>
                    <?php endif; ?>
                </p>

                <?php if (isset($_SESSION['user_id'])): ?>
                <a href="index.php?module=pemesanan&action=create&event_id=<?= $event['id'] ?>" class="btn-primary">
                    <i class="fas fa-ticket-alt"></i> Pesan
                </a>
                <a href="index.php?module=event&action=detail&id=<?= $event['id'] ?>" class="btn-secondary"
                    style="margin-left:8px;">Lihat</a>
                <?php else: ?>
                <a href="index.php?page=login" class="btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Login untuk Pesan
                </a>
                <a href="index.php?module=event&action=detail&id=<?= $event['id'] ?>" class="btn-secondary"
                    style="margin-left:8px;">Lihat</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>