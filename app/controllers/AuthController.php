<?php
class AuthController {
    private $db;
    private $customerModel;

    public function __construct($db) {
        $this->db = $db;
        require_once __DIR__ . '/../models/CustomerModel.php';
        $this->customerModel = new CustomerModel($db);
    }

    // Login action
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=login');
            exit;
        }

        $role = isset($_POST['role']) ? $_POST['role'] : null;

        if ($role === 'user') {
            $this->loginUser();
        } elseif ($role === 'admin') {
            $this->loginAdmin();
        } else {
            header('Location: index.php?page=login&error=invalid');
            exit;
        }
    }

    // Login user (customer)
    private function loginUser() {
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        if (empty($email) || empty($password)) {
            header('Location: index.php?page=login&error=required');
            exit;
        }

        // Query customer by email
        $query = "SELECT * FROM customers WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nama'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = 'customer';
            $_SESSION['user_type'] = $user['role'];

            header('Location: landing.php?success=login');
            exit;
        } else {
            header('Location: index.php?page=login&error=invalid');
            exit;
        }
    }

    // Login admin
    private function loginAdmin() {
        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        if (empty($username) || empty($password)) {
            header('Location: index.php?page=login&error=required');
            exit;
        }

        // Hardcoded admin credentials
        if ($username === 'admin' && $password === 'admin') {
            $_SESSION['admin_id'] = 1;
            $_SESSION['admin_name'] = 'Admin';
            $_SESSION['admin_role'] = 'admin';

            header('Location: index.php?module=dashboard');
            exit;
        } else {
            header('Location: index.php?page=login&error=invalid');
            exit;
        }
    }

    // Register action
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=register');
            exit;
        }

        $nama = isset($_POST['nama']) ? trim($_POST['nama']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
        $no_telepon = isset($_POST['no_telepon']) ? trim($_POST['no_telepon']) : '';
        $role = isset($_POST['role']) ? trim($_POST['role']) : '';

        // Validation
        if (empty($nama) || empty($email) || empty($password) || empty($confirm_password) || empty($role)) {
            header('Location: index.php?page=register&error=required');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header('Location: index.php?page=register&error=invalid_email');
            exit;
        }

        if ($password !== $confirm_password) {
            header('Location: index.php?page=register&error=password_mismatch');
            exit;
        }

        if (strlen($password) < 6) {
            header('Location: index.php?page=register&error=password_short');
            exit;
        }

        // Check if email already exists
        $query = "SELECT id FROM customers WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            header('Location: index.php?page=register&error=email_exists');
            exit;
        }

        // Insert new customer
        $query = "INSERT INTO customers (nama, email, password, no_telepon, role) 
                  VALUES (:nama, :email, :password, :no_telepon, :role)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':no_telepon', $no_telepon);
        $stmt->bindParam(':role', $role);

        if ($stmt->execute()) {
            header('Location: index.php?page=login&success=registered');
            exit;
        } else {
            header('Location: index.php?page=register&error=database');
            exit;
        }
    }

    // Logout action
    public function logout() {
        session_destroy();
        header('Location: landing.php');
        exit;
    }
}
?>
