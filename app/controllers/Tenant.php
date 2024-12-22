<?php

class Tenant extends Controller
{
    private $tenantModel;
    private $menuModel;
    private $categoryModel;
    private $trxModel;

    public function __construct() {
        $this->tenantModel = $this->model('TenantModel');
        $this->menuModel = $this->model('MenuModel');
        $this->categoryModel = $this->model('CategoryModel');
        $this->trxModel = $this->model('TrxModel');
    }

    public function toggleIsOpen() {
        $this->checkLoggedIn();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['id_tenant'])) {
                $id_tenant = $_POST['id_tenant'];
    
                $result = $this->tenantModel->toggleIsOpen($id_tenant);

                if ($result !== false) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Unable to toggle status.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid input: id_tenant is required.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
        }
    }

    private function checkLoggedIn() {
        if (!isset($_SESSION['tenant'])) {
            $data['error'] = "Please login First!";
            $this->view('templates/init');
            $this->view('tenant/login_register', $data);
            exit;
        }
        if (!isset($_SESSION['is_open'])) {
            $_SESSION['is_open'] = $this->tenantModel->getTenantStatus($_SESSION['tenant']['id']);
        }
    }

    public function login() {
        if (isset($_SESSION['tenant'])) {
            header('Location: /Tenant/index');
            exit;
        }

        $data = [
            'error' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->tenantModel->login($username, $password);

            if ($user) {
                if ($user['ACTIVE'] == 0) {
                    $data['error'] = 'Please verify your account.';
                } else {
                    $_SESSION['tenant'] = [
                        'id' => $user['ID_TENANT'],
                        'email' => $user['EMAIL'],
                        'username' => $user['USERNAME'],
                    ];
                    header('Location: /Tenant');
                    exit;
                }
            } else {
                $data['error'] = 'Invalid username or password';
            }
        }
        $this->view('templates/init');
        $this->view('tenant/login_register', $data);
    }

    public function register() {
        if (isset($_SESSION['tenant'])) {
            header('Location: /Tenant/index');
            exit;
        }

        $data = [
            'error' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars($_POST['username']);
            $password = $_POST['password'];
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $location_name = $_POST['tenant_location'];
            $location_booth = $_POST['tenant_number'];
            $tenant_name = $_POST['tenant_name'];

            if (empty($username) || empty($password) || empty($email) || empty($location_name) || empty($location_booth) || empty($tenant_name)) {
                $data['error'] = 'All fields must be filled.';
            } else {
                $existingUsers = $this->tenantModel->findTenantByUsernameOrEmail($username, $email);
                $userCount = count($existingUsers);
                if ($userCount === 2) {
                    $data['error'] = 'Email and username already used.';
                } elseif ($userCount === 1) {
                    if ($existingUsers[0]['USERNAME'] === $username && $existingUsers[0]['EMAIL'] === $email) {
                        $data['error'] = 'Email and username already used.';
                    } elseif ($existingUsers[0]['EMAIL'] === $email) {
                        if ($existingUsers[0]['ACTIVE'] == 0) {
                            $data['error'] = 'Please verify your account.';
                        } else {
                            $data['error'] = 'Email already used.';
                        }
                    } else {
                        $data['error'] = 'Username already used.';
                    }
                } else {
                    if ($this->tenantModel->register($tenant_name, $username, $password, $email, $location_name, $location_booth)) {
                        header('Location: /Tenant');
                        exit;
                    } else {
                        $data['error'] = 'Registration failed. Please try again.';
                    }
                }
            }
        }
    }

    public function index() {
        $this->checkLoggedIn();

        $tenantId = $_SESSION['tenant']['id'];

        $startDate = date('d-m-Y');
        $endDate = date('d-m-Y');

        $data = $this->tenantModel->getDashboardData($tenantId, $startDate, $endDate);

        $this->view('templates/init');
        $this->view('templates/tenant_header', $data);
        $this->view('tenant/index', $data);
    }

    public function getAnalytics($startDate, $endDate) {
        $tenantId = $_SESSION['tenant']['id'];

        $startDate = $startDate ?? date(format: 'd-m-Y');
        $endDate = $endDate ?? date('d-m-Y');

        $data = $this->tenantModel->getDashboardData($tenantId, $startDate, $endDate);
        echo json_encode([
            'totalOrders' => $data['totalOrders'] ?? 0,
            'totalRevenue' => $data['totalRevenue'] ?? 0,
            'chartLabels' => $data['chartLabels'] ?? [],
            'chartData' => $data['chartData'] ?? [],
        ]);
    }

    public function report() {
        $this->checkLoggedIn();
        $this->view('templates/init');
        $this->view('templates/tenant_header');
        $this->view('tenant/report');
    }

    public function settings() {
        $this->checkLoggedIn();
        $tenantId = $_SESSION['tenant']['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tenantName = htmlspecialchars($_POST['tenant_name'] ?? '');
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';


            if (empty($tenantName)) {
                $data['error'] = 'Nama Tenant tidak boleh kosong.';
            } elseif (!empty($newPassword) && $newPassword !== $confirmPassword) {
                $data['error'] = 'Password baru dan konfirmasi tidak cocok.';
            } else {
                $tenant = $this->tenantModel->getTenantById($tenantId);
                if (!password_verify($currentPassword, $tenant['PASSWORD'])) {
                    $data['error'] = 'Password saat ini salah.';
                } else {
                    $hashedPassword = !empty($newPassword) ? password_hash($newPassword, PASSWORD_BCRYPT) : null;

                    $isUpdated = $this->tenantModel->updateTenantProfile($tenantId, $tenantName, $hashedPassword);

                    if ($isUpdated) {
                        $data['success'] = 'Profil berhasil diperbarui.';
                    } else {
                        $data['error'] = 'Gagal memperbarui profil.';
                    }
                }
            }
        }

        $tenantData = $this->tenantModel->getTenantById($tenantId);

        $data = [
            'tenant_name' => $tenantData['TENANT_NAME'] ?? '',
            'username' => $tenantData['USERNAME'] ?? '',
            'email' => $tenantData['EMAIL'] ?? '',
            'location_name' => $tenantData['LOCATION_NAME'] ?? '',
            'location_booth' => $tenantData['LOCATION_BOOTH'] ?? '',
        ];

        $this->view('templates/init');
        $this->view('templates/tenant_header', $data);
        $this->view('tenant/settings', $data);
    }

    public function order($action = 'view') {
        $this->checkLoggedIn();

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && $action !== 'view'  && $action !== 'history') {
            header('Location: /Tenant/order');
        }

        switch ($action) {
            case 'accept':
                $this->updateOrder('Accept');
                break;
            case 'complete':
                $this->updateOrder('Completed');
                break;
            case 'pickup':
                $this->updateOrder('Pickup');
                break;
            case 'history':
                $this->orderHistory();
                break;    
            default:
                $this->viewOrders();
                break;
        }
    }

    private function viewOrders() {
        $transactions = $this->trxModel->getTransactionsByTenant($_SESSION['tenant']['id']);
    
        $data['transactions'] = $this->groupTransactions($transactions);
        $this->view('templates/init');
        $this->view('templates/tenant_header');
        $this->view('tenant/order', $data);
    }

    private function updateOrder($action) {
        if ($action != 'Accept' && $action != 'Completed' && $action != 'Pickup') {
            return false;
        }

        $id_transaction = isset($_POST['id_transaction']) ? $_POST['id_transaction'] : null;

        if (empty($id_transaction)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid id Transaction!']);
        }
    
        $updated = $this->trxModel->updateTransactionStatus($id_transaction, $action);

        if ($updated) {
            echo json_encode(['status' => 'success', 'message' => 'Transaction updated successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update transaction status.']);
        }
    }

    private function orderHistory() {
        $this->checkLoggedIn();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $start_date = isset($_POST['startDate']) ? $_POST['startDate'] : null;
            $end_date = isset($_POST['endDate']) ? $_POST['endDate'] : null;
            $transactions = $this->trxModel->getTransactionsByTenantandDate($_SESSION['tenant']['id'], $start_date, $end_date);
            echo json_encode($this->groupTransactions($transactions));
            exit;
        }

        $transactions = $this->trxModel->getTransactionsByTenant($_SESSION['tenant']['id']);

        $data['transactions'] = $this->groupTransactions($transactions);
        $this->view('templates/init');
        $this->view('templates/tenant_header');
        $this->view('tenant/history', $data);
    }

    private function groupTransactions($transactions) {
        $groupedTransactions = [];
        foreach ($transactions as $transaction) {
            $id_transaction = $transaction['ID_TRANSACTION'];
            if (!isset($groupedTransactions[$id_transaction])) {
                $date = DateTime::createFromFormat('d-M-y h.i.s.u A', $transaction['TRX_DATETIME']);
                $formattedDate = $date ? $date->format('d M Y, h:i A') : 'Invalid date';
                $groupedTransactions[$id_transaction] = [
                    'ID_TRANSACTION' => $id_transaction,
                    'TRX_DATETIME' => $formattedDate,
                    'TRX_PRICE' => $transaction['TRX_PRICE'],
                    'TRX_METHOD' => $transaction['TRX_METHOD'],
                    'TRX_STATUS' => $transaction['TRX_STATUS'],
                    'details' => []
                ];
            }
            $groupedTransactions[$id_transaction]['details'][] = [
                'ID_MENU' => $transaction['ID_MENU'],
                'QTY' => $transaction['QTY'],
                'QTY_PRICE' => $transaction['QTY_PRICE'],
                'PKG_PRICE' => $transaction['PKG_PRICE'],
                'NOTES' => $transaction['NOTES'],
                'STATUS' => $transaction['STATUS'],
                'NAME' => $transaction['NAME'],
                'PRICE' => $transaction['PRICE'],
                'IMAGE_PATH' => $transaction['IMAGE_PATH'],
                'MENU_TYPE' => $transaction['MENU_TYPE']
            ];
        }

        return array_values($groupedTransactions);
    }

    // Menu functions
    public function menu($action = 'view') {
        $this->checkLoggedIn();

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && $action !== 'view') {
            header('Location: /Tenant/menu');
        }

        switch ($action) {
            case 'add':
                $this->addMenu();
                break;
            case 'update':
                $this->updateMenu();
                break;
            case 'delete':
                $this->deleteMenu();
                break;
            case 'updateStatus':
                $this->updateMenuStatus();
                break;
            default:
                $this->viewMenus();
                break;
        }
    }

    private function viewMenus() {
        $tenant_id = $_SESSION['tenant']['id'] ?? null;
        if (!$tenant_id) {
            throw new Exception("Tenant ID not found in session.");
        }

        $menus = $this->menuModel->getMenusByTenant($tenant_id);

        error_log("Menus Data: " . print_r($menus, true));

        $data = [
            'page' => 'Menu - ' . $_SESSION['tenant']['username'],
            'menus' => $menus,
            'categories' => $this->categoryModel->getCategory()
        ];

        $this->view('templates/tenant_header', $data);
        $this->view('templates/init', $data);
        $this->view('tenant/menu', $data);
    }

    private function addMenu() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_tenant = $_SESSION['tenant']['id'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $pkg_price = $_POST['pkg_price'] ?? null;
            $menu_type = $_POST['menu_type'];
            $id_category = $_POST['id_category'];

            if (empty($name) || empty($price) || empty($menu_type) || empty($id_category)) {
                echo json_encode(['status' => 'error', 'message' => 'Required fields are missing']);
                return;
            }

            $image_path = null;
            if (!empty($_FILES['image_path']['name'])) {
                $image_path = $this->uploadImage($_FILES['image_path']);
                if (!$image_path) {
                    echo json_encode(['status' => 'error', 'message' => 'Invalid image file']);
                    return;
                }
            }

            $result = $this->menuModel->addMenu($id_tenant, $name, $price, $pkg_price, $image_path, $menu_type, $id_category);

            if ($result['status'] === 'success') {
                header('Location: /tenant/menu');
                exit;
            } else {
                header('Location: /tenant/menu?error=' . urlencode($result['message']));
                exit;
            }
        }
    }

    private function updateMenu() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_menu = $_POST['id_menu'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $pkg_price = $_POST['pkg_price'] ?? null;
            $menu_type = $_POST['menu_type'];
            $id_category = $_POST['id_category'];

            if (empty($id_menu) || empty($name) || empty($price) || empty($menu_type) || empty($id_category)) {
                echo json_encode(['status' => 'error', 'message' => 'Required fields are missing']);
                return;
            }

            $image_path = null;
            if (!empty($_FILES['image_path']['name'])) {
                $image_path = $this->uploadImage($_FILES['image_path']);
                if (!$image_path) {
                    echo json_encode(['status' => 'error', 'message' => 'Invalid image file']);
                    return;
                }
            }

            $result = $this->menuModel->updateMenu($id_menu, $name, $price, $pkg_price, $image_path, $menu_type, $id_category);
            if ($result['status'] === 'success') {
                header('Location: /tenant/menu');
                exit;
            } else {
                header('Location: /tenant/menu?error=' . urlencode($result['message']));
                exit;
            }
        }
    }

    private function deleteMenu() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $menuId = $_POST['id_menu'] ?? null;

            if (empty($menuId)) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid data!']);
                return;
            }

            $deleted = $this->menuModel->deleteMenu($menuId);

            if ($deleted) {
                echo json_encode(['status' => 'success', 'message' => 'Menu deleted successfully!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete menu.']);
            }
        }
    }

    private function uploadImage($image) {
        if ($image['error'] == 0) {
            $targetDir = "./assets/img/menu/";
            $nameFile = uniqid() . "-" . basename($image["name"]);
            $moveFile = $targetDir . $nameFile;
            if (move_uploaded_file($image["tmp_name"], $moveFile)) {
                return $nameFile;
            }
        }
        return null;
    }

    private function updateMenuStatus() {
        $menuId = isset($_POST['menu_id']) ? $_POST['menu_id'] : null;
        $currentStatus = isset($_POST['current_status']) ? $_POST['current_status'] : null;
    
        if (empty($menuId) || !in_array($currentStatus, ['0', '1'])) {
            return json_encode(['status' => 'error', 'message' => 'Invalid data!']);
        }
    
        $newStatus = $currentStatus == '1' ? 0 : 1;
        $updated = $this->menuModel->updateMenuStatus($menuId, $newStatus);
        if ($updated) {
            return json_encode(['status' => 'success', 'message' => 'Menu status updated successfully!']);
        } else {
            return json_encode(['status' => 'error', 'message' => 'Failed to update menu status.']);
        }
    }
    
    // logout functions
    public function logout() {
        $this->checkLoggedIn();
        unset($_SESSION['tenant']);
        header("Location: /Tenant");
        exit();
    }
}