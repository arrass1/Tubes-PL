<?php
// Start session
session_start();

// Define base path for assets
define('BASE_PATH', dirname(__FILE__) . '/');
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/');

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
    include 'app/views/login.php';
    exit;
} elseif ($page === 'register') {
    include 'app/views/register.php';
    exit;
} elseif ($page === 'landing') {
    include 'app/views/landing.php';
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
    header('Location: index.php?page=landing');
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
        require_once 'app/controllers/EventController.php';
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
            case 'detail':
                $controller->detail();
                break;
                case 'public':
                    // Public listing for users
                    $controller->publicList();
                    break;
            default:
                $controller->index();
                break;
        }
        break;
        
    case 'user':
        require_once 'app/controllers/UserController.php';
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
        require_once 'app/controllers/TiketController.php';
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
        require_once 'app/controllers/PemesananController.php';
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

    case 'pembayaran':
        require_once 'app/controllers/PembayaranController.php';
        $controller = new PembayaranController($db);

        switch ($action) {
            case 'index':
                $controller->index();
                break;
            case 'process':
                $controller->process();
                break;
            default:
                $controller->index();
                break;
        }
        break;

    case 'etiket':
        require_once 'app/controllers/ETiketController.php';
        $controller = new ETiketController($db);

        switch ($action) {
            case 'show':
                $controller->show();
                break;
            case 'my_tickets':
                $controller->myTickets();
                break;
            default:
                $controller->show();
                break;
        }
        break;
        
    default:
        require_once 'app/controllers/EventController.php';
        $controller = new EventController($db);
        $controller->dashboard();
        break;
}
?>