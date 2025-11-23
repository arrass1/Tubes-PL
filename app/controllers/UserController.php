<?php
require_once __DIR__ . '/../models/CustomerModel.php';

class UserController {
    private $customerModel;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->customerModel = new CustomerModel($db);
    }

    public function index() {
        $module = 'user';
        $pageTitle = 'Manajemen Customer';
        $users = $this->customerModel->getAllCustomers();
        include __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/user/index.php';
        include __DIR__ . '/../views/layout/footer.php';
    }

    public function create() {
        $module = 'user';
        $pageTitle = 'Tambah Customer';
        include __DIR__ . '/../views/layout/header.php';
        include __DIR__ . '/../views/user/create.php';
        include __DIR__ . '/../views/layout/footer.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama' => $_POST['nama'],
                'email' => $_POST['email'],
                'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
                'no_telepon' => $_POST['no_telepon'],
                'role' => $_POST['role'] ?? 'customer'
            ];

            if ($this->customerModel->createCustomer($data)) {
                header('Location: index.php?module=user&message=success_create');
                exit();
            } else {
                header('Location: index.php?module=user&message=error_create');
                exit();
            }
        }
    }

    public function edit() {
        if (isset($_GET['id'])) {
            $module = 'user';
            $pageTitle = 'Edit Customer';
            $user = $this->customerModel->getCustomerById($_GET['id']);
            if ($user) {
                include __DIR__ . '/../views/layout/header.php';
                include __DIR__ . '/../views/user/edit.php';
                include __DIR__ . '/../views/layout/footer.php';
            } else {
                header('Location: index.php?module=user&message=not_found');
                exit();
            }
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = $_POST['id'];
            $data = [
                'nama' => $_POST['nama'],
                'email' => $_POST['email'],
                'no_telepon' => $_POST['no_telepon'],
                'role' => $_POST['role'] ?? 'customer'
            ];

            if ($this->customerModel->updateCustomer($id, $data)) {
                header('Location: index.php?module=user&message=success_update');
                exit();
            } else {
                header('Location: index.php?module=user&message=error_update');
                exit();
            }
        }
    }

    public function delete() {
        if (isset($_GET['id'])) {
            if ($this->customerModel->deleteCustomer($_GET['id'])) {
                header('Location: index.php?module=user&message=success_delete');
                exit();
            } else {
                header('Location: index.php?module=user&message=error_delete');
                exit();
            }
        }
    }
}
?>
