<?php
class PembayaranController {
    private $db;
    private $pembayaranModel;
    private $pemesananModel;
    private $tiketModel;

    public function __construct($db) {
        $this->db = $db;
        require_once __DIR__ . '/../models/PembayaranModel.php';
        require_once __DIR__ . '/../models/PemesananModel.php';
        require_once __DIR__ . '/../models/TiketModel.php';
        $this->pembayaranModel = new PembayaranModel($db);
        $this->pemesananModel = new PemesananModel($db);
        $this->tiketModel = new TiketModel($db);
    }

    /**
     * Show payment page
     */
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        if (!isset($_GET['pemesanan_id'])) {
            header('Location: index.php?module=pemesanan&action=my_orders');
            exit;
        }

        $pemesanan_id = $_GET['pemesanan_id'];
        
        // Get pemesanan details
        $pemesanan = $this->pemesananModel->getPemesananById($pemesanan_id);
        
        if (!$pemesanan || $pemesanan['customer_id'] != $_SESSION['user_id']) {
            header('Location: index.php?module=pemesanan&action=my_orders&error=unauthorized');
            exit;
        }

        // Check if already paid
        $existingPayment = $this->pembayaranModel->getPembayaranByPemesananId($pemesanan_id);
        if ($existingPayment && $existingPayment['status_pembayaran'] === 'Berhasil') {
            header('Location: index.php?module=etiket&action=show&kode=' . $existingPayment['kode_pembayaran']);
            exit;
        }

        $module = 'pembayaran';
        $pageTitle = 'Pembayaran';
        
        include __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/pembayaran/index.php';
        include __DIR__ . '/../views/layout/footer.php';
    }

    /**
     * Process payment
     */
    public function process() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $pemesanan_id = isset($_POST['pemesanan_id']) ? (int)$_POST['pemesanan_id'] : null;
        $metode_pembayaran = isset($_POST['metode_pembayaran']) ? $_POST['metode_pembayaran'] : null;

        if (!$pemesanan_id || !$metode_pembayaran) {
            header('Location: index.php?module=pemesanan&action=my_orders&error=invalid');
            exit;
        }

        // Get pemesanan details
        $pemesanan = $this->pemesananModel->getPemesananById($pemesanan_id);
        
        if (!$pemesanan || $pemesanan['customer_id'] != $_SESSION['user_id']) {
            header('Location: index.php?module=pemesanan&action=my_orders&error=unauthorized');
            exit;
        }

        // Check if ticket stock is sufficient
        if (!$this->tiketModel->hasEnoughStock($pemesanan['tiket_id'], $pemesanan['jumlah_tiket'])) {
            header('Location: index.php?module=pemesanan&action=my_orders&error=insufficient_stock');
            exit;
        }

        // Create payment record
        $data = [
            'pemesanan_id' => $pemesanan_id,
            'metode_pembayaran' => $metode_pembayaran,
            'jumlah_bayar' => $pemesanan['total_harga']
        ];

        $kode_pembayaran = $this->pembayaranModel->createPembayaran($data);

        if ($kode_pembayaran) {
            // Auto approve payment (simulasi pembayaran berhasil)
            $this->pembayaranModel->updateStatusPembayaran($kode_pembayaran, 'Berhasil');
            
            // Reduce ticket stock
            $this->tiketModel->reduceStok($pemesanan['tiket_id'], $pemesanan['jumlah_tiket']);
            
            // Update pemesanan status to approved
            $this->pemesananModel->updateStatusPemesanan($pemesanan_id, 'Disetujui');
            
            // Redirect to e-ticket
            header('Location: index.php?module=etiket&action=show&kode=' . $kode_pembayaran);
            exit;
        } else {
            header('Location: index.php?module=pemesanan&action=my_orders&error=payment_failed');
            exit;
        }
    }
}
?>