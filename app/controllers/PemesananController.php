<?php
class PemesananController {
    private $db;
    private $pemesananModel;
    private $eventModel;
    private $tiketModel;
    private $pembayaranModel;

    public function __construct($db) {
        $this->db = $db;
        require_once __DIR__ . '/../models/PemesananModel.php';
        require_once __DIR__ . '/../models/EventModel.php';
        require_once __DIR__ . '/../models/TiketModel.php';
        require_once __DIR__ . '/../models/PembayaranModel.php';
        $this->pemesananModel = new PemesananModel($db);
        $this->eventModel = new EventModel($db);
        $this->tiketModel = new TiketModel($db);
        $this->pembayaranModel = new PembayaranModel($db);
    }

    // Display all orders (for admin)
    public function index() {
        if (!isset($_SESSION['admin_role'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $module = 'pemesanan';
        $pageTitle = 'Manajemen Pemesanan';
        $pemesanan = $this->pemesananModel->getAllPemesanan();
        
        include __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/pemesanan/index.php';
        include __DIR__ . '/../views/layout/footer.php';
    }

    // Create order (for users) - WITH EVENT ID REQUIRED
    public function create() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        // Event ID harus ada - user hanya bisa membuat pesanan dari halaman event
        if (!isset($_GET['event_id']) || empty($_GET['event_id'])) {
            header('Location: index.php?module=event&action=public');
            exit;
        }

        $module = 'pemesanan';
        $pageTitle = 'Buat Pesanan';
        
        $event_id = (int)$_GET['event_id'];
        $event = $this->eventModel->getEventById($event_id);
        
        if (!$event) {
            header('Location: index.php?module=event&action=public&error=event_not_found');
            exit;
        }
        
        // Get tickets for this specific event
        $tickets = $this->tiketModel->getTiketByEventId($event_id);
        
        if (empty($tickets)) {
            header('Location: index.php?module=event&action=public&error=no_tickets');
            exit;
        }
        
        include __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/pemesanan/create.php';
        include __DIR__ . '/../views/layout/footer.php';
    }

    // Store new order
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $tiket_id = isset($_POST['tiket_id']) ? (int)$_POST['tiket_id'] : null;
        $jumlah_tiket = isset($_POST['jumlah_tiket']) ? (int)$_POST['jumlah_tiket'] : 0;
        $event_id = isset($_POST['event_id']) ? (int)$_POST['event_id'] : null;

        if (!$tiket_id || $jumlah_tiket <= 0) {
            $redirect = $event_id ? "index.php?module=pemesanan&action=create&event_id=$event_id&error=invalid" : "index.php?module=pemesanan&action=create&error=invalid";
            header('Location: ' . $redirect);
            exit;
        }

        // Get tiket details
        $tiket = $this->tiketModel->getTiketById($tiket_id);
        if (!$tiket) {
            $redirect = $event_id ? "index.php?module=pemesanan&action=create&event_id=$event_id&error=tiket_not_found" : "index.php?module=pemesanan&action=create&error=tiket_not_found";
            header('Location: ' . $redirect);
            exit;
        }

        // Validate stock - Check if requested quantity exceeds available stock
        if ($jumlah_tiket > $tiket['stok']) {
            $redirect = $event_id ? "index.php?module=pemesanan&action=create&event_id=$event_id&error=insufficient_stock" : "index.php?module=pemesanan&action=create&error=insufficient_stock";
            header('Location: ' . $redirect);
            exit;
        }

        $total_harga = $tiket['harga'] * $jumlah_tiket;

        $data = [
            'customer_id' => $_SESSION['user_id'],
            'tiket_id' => $tiket_id,
            'jumlah_tiket' => $jumlah_tiket,
            'total_harga' => $total_harga
        ];

        if ($this->pemesananModel->createPemesanan($data)) {
            // Get the last inserted pemesanan ID
            $pemesanan_id = $this->db->lastInsertId();
            
            // Redirect to payment page instead of my_orders
            header('Location: index.php?module=pembayaran&action=index&pemesanan_id=' . $pemesanan_id);
            exit;
        } else {
            $redirect = $event_id ? "index.php?module=pemesanan&action=create&event_id=$event_id&error=database" : "index.php?module=pemesanan&action=create&error=database";
            header('Location: ' . $redirect);
            exit;
        }
    }

    // View customer's orders
    public function myOrders() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $module = 'pemesanan';
        $pageTitle = 'Pesanan Saya';
        $pemesanan = $this->pemesananModel->getPemesananByCustomer($_SESSION['user_id']);

        // attach pembayaran info (if exists) so view can link to the official etiket controller
        foreach ($pemesanan as $k => $p) {
            $pay = $this->pembayaranModel->getPembayaranByPemesananId($p['id']);
            if ($pay) {
                $pemesanan[$k]['kode_pembayaran'] = $pay['kode_pembayaran'];
                $pemesanan[$k]['pembayaran_status'] = $pay['status_pembayaran'];
            } else {
                $pemesanan[$k]['kode_pembayaran'] = null;
                $pemesanan[$k]['pembayaran_status'] = null;
            }
        }
        
        include __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/pemesanan/my_orders.php';
        include __DIR__ . '/../views/layout/footer.php';
    }

    // Show e-ticket for a pemesanan (user only)
    public function eticket() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if (!$id) {
            header('Location: index.php?module=pemesanan&error=not_found');
            exit;
        }

        $pem = $this->pemesananModel->getPemesananById($id);
        if (!$pem) {
            header('Location: index.php?module=pemesanan&error=not_found');
            exit;
        }

        // ensure the logged-in user owns this order (or is admin)
        if ($pem['customer_id'] != $_SESSION['user_id'] && !isset($_SESSION['admin_role'])) {
            header('Location: index.php?module=pemesanan&error=not_authorized');
            exit;
        }

        $module = 'pemesanan';
        $pageTitle = 'E-Ticket';

        include __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/pemesanan/eticket.php';
        include __DIR__ . '/../views/layout/footer.php';
    }

    // Approve order (admin only)
    public function approve() {
        if (!isset($_SESSION['admin_role'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        
        if ($id && $this->pemesananModel->updateStatusPemesanan($id, 'Disetujui')) {
            header('Location: index.php?module=pemesanan&success=approved');
            exit;
        } else {
            header('Location: index.php?module=pemesanan&error=failed');
            exit;
        }
    }

    // Reject order (admin only)
    public function reject() {
        if (!isset($_SESSION['admin_role'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        
        if ($id && $this->pemesananModel->updateStatusPemesanan($id, 'Ditolak')) {
            header('Location: index.php?module=pemesanan&success=rejected');
            exit;
        } else {
            header('Location: index.php?module=pemesanan&error=failed');
            exit;
        }
    }

    // Delete order (admin only)
    public function delete() {
        if (!isset($_SESSION['admin_role'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        
        if ($id && $this->pemesananModel->deletePemesanan($id)) {
            header('Location: index.php?module=pemesanan&success=deleted');
            exit;
        } else {
            header('Location: index.php?module=pemesanan&error=failed');
            exit;
        }
    }
}
?>