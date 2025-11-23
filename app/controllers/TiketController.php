<?php
require_once __DIR__ . '/../models/TiketModel.php';
require_once __DIR__ . '/../models/EventModel.php';

class TiketController {
    private $tiketModel;
    private $eventModel;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->tiketModel = new TiketModel($db);
        $this->eventModel = new EventModel($db);
    }

    public function index() {
        $module = 'tiket';
        $pageTitle = 'Manajemen Tiket';
        $tiket = $this->tiketModel->getAllTiket();
        include __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/tiket/index.php';
        include __DIR__ . '/../views/layout/footer.php';
    }

    public function create() {
        $module = 'tiket';
        $pageTitle = 'Tambah Tiket';
        $events = $this->eventModel->getAllEvents();
        include __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/tiket/create.php';
        include __DIR__ . '/../views/layout/footer.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'event_id' => $_POST['event_id'],
                'nama_tiket' => $_POST['nama_tiket'],
                'harga' => $_POST['harga'],
                'stok' => $_POST['stok']
            ];

            if ($this->tiketModel->createTiket($data)) {
                header('Location: index.php?module=tiket&message=success_create');
                exit();
            } else {
                header('Location: index.php?module=tiket&message=error_create');
                exit();
            }
        }
    }

    public function edit() {
        if (isset($_GET['id'])) {
            $module = 'tiket';
            $pageTitle = 'Edit Tiket';
            $tiket = $this->tiketModel->getTiketById($_GET['id']);
            $events = $this->eventModel->getAllEvents();
            if ($tiket) {
                include __DIR__ . '/../views/layout/header.php';
                include __DIR__ . '/../views/tiket/edit.php';
                include __DIR__ . '/../views/layout/footer.php';
            } else {
                header('Location: index.php?module=tiket&message=not_found');
                exit();
            }
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = $_POST['id'];
            $data = [
                'event_id' => $_POST['event_id'],
                'nama_tiket' => $_POST['nama_tiket'],
                'harga' => $_POST['harga'],
                'stok' => $_POST['stok']
            ];

            if ($this->tiketModel->updateTiket($id, $data)) {
                header('Location: index.php?module=tiket&message=success_update');
                exit();
            } else {
                header('Location: index.php?module=tiket&message=error_update');
                exit();
            }
        }
    }

    public function delete() {
        if (isset($_GET['id'])) {
            if ($this->tiketModel->deleteTiket($_GET['id'])) {
                header('Location: index.php?module=tiket&message=success_delete');
                exit();
            } else {
                header('Location: index.php?module=tiket&message=error_delete');
                exit();
            }
        }
    }
}
?>
