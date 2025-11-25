<?php
class PemesananController {
    private $db;
    private $pemesananModel;
    private $eventModel;
    private $tiketModel;

    public function __construct($db) {
        $this->db = $db;
        require_once __DIR__ . '/../models/PemesananModel.php';
        require_once __DIR__ . '/../models/EventModel.php';
        require_once __DIR__ . '/../models/TiketModel.php';
        $this->pemesananModel = new PemesananModel($db);
        $this->eventModel = new EventModel($db);
        $this->tiketModel = new TiketModel($db);
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

    // Create order (for users)
    public function create() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $module = 'pemesanan';
        $pageTitle = 'Buat Pesanan';
        // Show available tickets (each ticket includes event name)
        $tickets = $this->tiketModel->getAllTiket();
        
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

        if (!$tiket_id || $jumlah_tiket <= 0) {
            header('Location: index.php?module=pemesanan&action=create&error=invalid');
            exit;
        }

        // Get tiket details
        $tiket = $this->tiketModel->getTiketById($tiket_id);
        if (!$tiket) {
            header('Location: index.php?module=pemesanan&action=create&error=tiket_not_found');
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
            header('Location: index.php?module=pemesanan&action=my_orders&success=created');
            exit;
        } else {
            header('Location: index.php?module=pemesanan&action=create&error=database');
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
        
        include __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/pemesanan/my_orders.php';
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
