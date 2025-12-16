<?php
class ETiketController {
    private $db;
    private $pembayaranModel;

    public function __construct($db) {
        $this->db = $db;
        require_once __DIR__ . '/../models/PembayaranModel.php';
        $this->pembayaranModel = new PembayaranModel($db);
    }

    /**
     * Show e-ticket
     */
    public function show() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        if (!isset($_GET['kode'])) {
            header('Location: index.php?module=pemesanan&action=my_orders');
            exit;
        }

        $kode_pembayaran = $_GET['kode'];
        
        // Get payment and order details
        $tiket = $this->pembayaranModel->getPembayaranByKode($kode_pembayaran);
        
        if (!$tiket || $tiket['customer_id'] != $_SESSION['user_id']) {
            header('Location: index.php?module=pemesanan&action=my_orders&error=unauthorized');
            exit;
        }

        if ($tiket['status_pembayaran'] !== 'Berhasil') {
            header('Location: index.php?module=pemesanan&action=my_orders&error=payment_not_complete');
            exit;
        }

        $module = 'etiket';
        $pageTitle = 'E-Tiket';
        
        include __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/etiket/show.php';
        include __DIR__ . '/../views/layout/footer.php';
    }

    /**
     * List all user's tickets
     */
    public function myTickets() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $module = 'etiket';
        $pageTitle = 'Tiket Saya';

        // Get all approved orders with payment
        $query = "SELECT p.kode_pembayaran, pm.kode_booking, pm.jumlah_tiket, pm.total_harga, 
                         e.nama_event, e.tanggal_event, e.lokasi, t.nama_tiket, p.tanggal_bayar
                  FROM pembayaran p
                  LEFT JOIN pemesanan pm ON p.pemesanan_id = pm.id
                  LEFT JOIN tiket t ON pm.tiket_id = t.id
                  LEFT JOIN events e ON t.event_id = e.id
                  WHERE pm.customer_id = :customer_id AND p.status_pembayaran = 'Berhasil'
                  ORDER BY p.tanggal_bayar DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':customer_id', $_SESSION['user_id']);
        $stmt->execute();
        $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/etiket/index.php';
        include __DIR__ . '/../views/layout/footer.php';
    }
}
?>