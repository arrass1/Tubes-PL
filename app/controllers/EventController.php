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
            // Validate that event date is not in the past
            $tanggal_event = $_POST['tanggal_event'];
            $today = date('Y-m-d');
            
            if ($tanggal_event < $today) {
                header('Location: index.php?module=event&action=create&message=error_past_date');
                exit();
            }

            $data = [
                'nama_event' => $_POST['nama_event'],
                'deskripsi' => $_POST['deskripsi'],
                'tanggal_event' => $tanggal_event,
                'lokasi' => $_POST['lokasi'],
                'kategori' => $_POST['kategori'],
                'status' => $_POST['status']
            ];

            // Handle file upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $uploadedImage = $this->eventModel->uploadImage($_FILES['image']);
                if ($uploadedImage === false) {
                    header('Location: index.php?module=event&message=error_upload');
                    exit();
                } elseif ($uploadedImage) {
                    $data['image'] = $uploadedImage;
                }
            }

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
            
            // Validate that event date is not in the past
            $tanggal_event = $_POST['tanggal_event'];
            $today = date('Y-m-d');
            
            if ($tanggal_event < $today) {
                header('Location: index.php?module=event&action=edit&id=' . $id . '&message=error_past_date');
                exit();
            }

            $data = [
                'nama_event' => $_POST['nama_event'],
                'deskripsi' => $_POST['deskripsi'],
                'tanggal_event' => $tanggal_event,
                'lokasi' => $_POST['lokasi'],
                'kategori' => $_POST['kategori'],
                'status' => $_POST['status']
            ];

            // Handle file upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                // Get old image
                $oldEvent = $this->eventModel->getEventById($id);
                if ($oldEvent && $oldEvent['image']) {
                    $this->eventModel->deleteImage($oldEvent['image']);
                }

                $uploadedImage = $this->eventModel->uploadImage($_FILES['image']);
                if ($uploadedImage === false) {
                    header('Location: index.php?module=event&action=edit&id=' . $id . '&message=error_upload');
                    exit();
                } elseif ($uploadedImage) {
                    $data['image'] = $uploadedImage;
                }
            }

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
            // Get event to delete image
            $event = $this->eventModel->getEventById($_GET['id']);
            if ($event && $event['image']) {
                $this->eventModel->deleteImage($event['image']);
            }

            if ($this->eventModel->deleteEvent($_GET['id'])) {
                header('Location: index.php?module=event&message=success_delete');
                exit();
            } else {
                header('Location: index.php?module=event&message=error_delete');
                exit();
            }
        }
    }

    // Show event detail (NEW METHOD)
    public function detail() {
        if (!isset($_GET['id'])) {
            header('Location: index.php?page=landing');
            exit;
        }

        $event_id = $_GET['id'];
        $event = $this->eventModel->getEventById($event_id);

        if (!$event) {
            header('Location: index.php?page=landing&error=not_found');
            exit;
        }

        // Get tickets for this event
        require_once __DIR__ . '/../models/TiketModel.php';
        $tiketModel = new TiketModel($this->db);
        $tiket = $tiketModel->getTiketByEventId($event_id);

        $module = 'event';
        $pageTitle = 'Detail Event';

        include __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/event/detail.php';
        include __DIR__ . '/../views/layout/footer.php';
    }

    // Public listing for users
    public function publicList() {
        $module = 'event';
        $pageTitle = 'Daftar Event';

        // Get all categories for filter
        $categories = $this->eventModel->getAllCategories();

        // Get events for public listing
        if (isset($_GET['kategori']) && !empty($_GET['kategori'])) {
            // Filter by category
            $events = $this->eventModel->getEventsByCategory($_GET['kategori']);
        } else {
            // Show all events
            $events = $this->eventModel->getAllEvents();
        }

        // Load tiket model to determine price info for each event
        require_once __DIR__ . '/../models/TiketModel.php';
        $tiketModel = new TiketModel($this->db);

        foreach ($events as &$ev) {
            $tickets = $tiketModel->getTiketByEventId($ev['id']);
            if (!empty($tickets)) {
                $prices = array_map(function($t){ return (float)$t['harga']; }, $tickets);
                $ev['min_price'] = min($prices);
            } else {
                $ev['min_price'] = null;
            }
        }

        include __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/event/public.php';
        include __DIR__ . '/../views/layout/footer.php';
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