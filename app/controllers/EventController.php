<?php
require_once __DIR__ . '/../models/EventModel.php';

class EventController {
    private $eventModel;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->eventModel = new EventModel($db);
    }

    // Display all events
    public function index() {
        $module = 'event';
        $pageTitle = 'Manajemen Event';
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $events = $this->eventModel->searchEvents($_GET['search']);
        } else {
            $events = $this->eventModel->getAllEvents();
        }
        include __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/event/index.php';
        include __DIR__ . '/../views/layout/footer.php';
    }

    // Show create form
    public function create() {
        $module = 'event';
        $pageTitle = 'Tambah Event';
        include __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/event/create.php';
        include __DIR__ . '/../views/layout/footer.php';
    }

    // Store new event
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama_event' => $_POST['nama_event'],
                'deskripsi' => $_POST['deskripsi'],
                'tanggal_event' => $_POST['tanggal_event'],
                'lokasi' => $_POST['lokasi'],
                'harga_tiket' => $_POST['harga_tiket'],
                'kapasitas' => $_POST['kapasitas'],
                'kategori' => $_POST['kategori'],
                'status' => $_POST['status']
            ];

            if ($this->eventModel->createEvent($data)) {
                header('Location: index.php?module=event&message=success_create');
                exit();
            } else {
                header('Location: index.php?module=event&message=error_create');
                exit();
            }
        }
    }

    // Show edit form
    public function edit() {
        if (isset($_GET['id'])) {
            $module = 'event';
            $pageTitle = 'Edit Event';
            $event = $this->eventModel->getEventById($_GET['id']);
            if ($event) {
                include __DIR__ . '/../views/layout/header.php';
                include __DIR__ . '/../views/event/edit.php';
                include __DIR__ . '/../views/layout/footer.php';
            } else {
                header('Location: index.php?module=event&message=not_found');
                exit();
            }
        }
    }

    // Update event
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = $_POST['id'];
            $data = [
                'nama_event' => $_POST['nama_event'],
                'deskripsi' => $_POST['deskripsi'],
                'tanggal_event' => $_POST['tanggal_event'],
                'lokasi' => $_POST['lokasi'],
                'harga_tiket' => $_POST['harga_tiket'],
                'kapasitas' => $_POST['kapasitas'],
                'kategori' => $_POST['kategori'],
                'status' => $_POST['status']
            ];

            if ($this->eventModel->updateEvent($id, $data)) {
                header('Location: index.php?module=event&message=success_update');
                exit();
            } else {
                header('Location: index.php?module=event&message=error_update');
                exit();
            }
        }
    }

    // Delete event
    public function delete() {
        if (isset($_GET['id'])) {
            if ($this->eventModel->deleteEvent($_GET['id'])) {
                header('Location: index.php?module=event&message=success_delete');
                exit();
            } else {
                header('Location: index.php?module=event&message=error_delete');
                exit();
            }
        }
    }

    // Dashboard
    public function dashboard() {
        $module = 'dashboard';
        $pageTitle = 'Dashboard';
        $stats = $this->eventModel->getStatistics();
        $recentEvents = $this->eventModel->getAllEvents();

        // Add pemesanan stats if admin
        if (isset($_SESSION['admin_role'])) {
            require_once __DIR__ . '/../models/PemesananModel.php';
            $pemesananModel = new PemesananModel($this->db);
            $pemesananStats = $pemesananModel->getStatistics();
            $stats = array_merge($stats, $pemesananStats);
            $recentPemesanan = $pemesananModel->getAllPemesanan();
        }

        include __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/dashboard.php';
        include __DIR__ . '/../views/layout/footer.php';
    }
}
?>