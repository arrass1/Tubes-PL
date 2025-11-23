<?php
// Start session
session_start();

// Include database connection
require_once 'config/database.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Get page and action from URL
$page = isset($_GET['page']) ? $_GET['page'] : null;
$action = isset($_GET['action']) ? $_GET['action'] : null;
$module = isset($_GET['module']) ? $_GET['module'] : 'dashboard';

// Handle authentication pages
if ($page === 'login') {
    include 'login.php';
    exit;
} elseif ($page === 'register') {
    include 'register.php';
    exit;
} elseif ($page === 'landing') {
    include 'landing.php';
    exit;
}

// Handle auth actions
if ($action === 'login') {
    require_once 'app/controllers/AuthController.php';
    $controller = new AuthController($db);
    $controller->login();
    exit;
} elseif ($action === 'register') {
    require_once 'app/controllers/AuthController.php';
    $controller = new AuthController($db);
    $controller->register();
    exit;
} elseif ($action === 'logout') {
    require_once 'app/controllers/AuthController.php';
    $controller = new AuthController($db);
    $controller->logout();
    exit;
}

// Check authentication for dashboard access (admin only)
if ($module === 'dashboard' && empty($_SESSION['admin_role'])) {
    header('Location: landing.php');
    exit;
}

// Route handling
switch ($module) {
    case 'dashboard':
        require_once 'app/controllers/EventController.php';
        $controller = new EventController($db);
        $controller->dashboard();
        break;
        
    case 'event':
        require_once __DIR__ . '/app/controllers/EventController.php';
        $controller = new EventController($db);
        
        switch ($action) {
            case 'index':
                $controller->index();
                break;
            case 'create':
                $controller->create();
                break;
            case 'store':
                $controller->store();
                break;
            case 'edit':
                $controller->edit();
                break;
            case 'update':
                $controller->update();
                break;
            case 'delete':
                $controller->delete();
                break;
            default:
                $controller->index();
                break;
        }
        break;
    case 'user':
        require_once __DIR__ . '/app/controllers/UserController.php';
        $controller = new UserController($db);

        switch ($action) {
            case 'index':
                $controller->index();
                break;
            case 'create':
                $controller->create();
                break;
            case 'store':
                $controller->store();
                break;
            case 'edit':
                $controller->edit();
                break;
            case 'update':
                $controller->update();
                break;
            case 'delete':
                $controller->delete();
                break;
            default:
                $controller->index();
                break;
        }
        break;

    case 'tiket':
        require_once __DIR__ . '/app/controllers/TiketController.php';
        $controller = new TiketController($db);

        switch ($action) {
            case 'index':
                $controller->index();
                break;
            case 'create':
                $controller->create();
                break;
            case 'store':
                $controller->store();
                break;
            case 'edit':
                $controller->edit();
                break;
            case 'update':
                $controller->update();
                break;
            case 'delete':
                $controller->delete();
                break;
            default:
                $controller->index();
                break;
        }
        break;

    case 'pemesanan':
        require_once __DIR__ . '/app/controllers/PemesananController.php';
        $controller = new PemesananController($db);

        switch ($action) {
            case 'index':
                $controller->index();
                break;
            case 'create':
                $controller->create();
                break;
            case 'store':
                $controller->store();
                break;
            case 'my_orders':
                $controller->myOrders();
                break;
            case 'approve':
                $controller->approve();
                break;
            case 'reject':
                $controller->reject();
                break;
            case 'delete':
                $controller->delete();
                break;
            default:
                $controller->index();
                break;
        }
        break;
        
    default:
        require_once __DIR__ . '/app/controllers/EventController.php';
        $controller = new EventController($db);
        $controller->dashboard();
        break;
}
?>