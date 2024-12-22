<?php

class Tenant extends Controller
{
    private $tenantModel;
    private $menuModel;
    private $categoryModel;

    public function __construct() {
        $this->tenantModel = $this->model('TenantModel');
        $this->menuModel = $this->model('MenuModel');
        $this->categoryModel = $this->model('CategoryModel');
    }

    private function checkLoggedIn() {
        if (!isset($_SESSION['tenant'])) {
            $data['error'] = "Please login First!";
            $this->view('templates/init');
            $this->view('tenant/login_register', $data);
            exit;
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
        $this->view('templates/tenant_header');
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

    public function orderlist() {
        $this->checkLoggedIn();
        $this->view('templates/init');
        $this->view('templates/tenant_header');
        $this->view('tenant/orderlist');
    }
    
    public function historytransaction() {
        $this->checkLoggedIn();
        $this->view('templates/init');
        $this->view('templates/tenant_header');
        $this->view('tenant/historytransaction');
    }

    public function report() {
        $this->checkLoggedIn();
        $this->view('templates/init');
        $this->view('templates/tenant_header');
        $this->view('tenant/report');
    }

    public function settings()
    {
        $this->checkLoggedIn();
    
        $tenantId = $_SESSION['tenant']['id'];
        $tenantData = $this->tenantModel->getTenantById($tenantId);
    
        $data = [
            'tenant_name' => $tenantData['TENANT_NAME'] ?? '',
            'username' => $tenantData['USERNAME'] ?? '',
            'email' => $tenantData['EMAIL'] ?? '',
            'location_name' => $tenantData['LOCATION_NAME'] ?? '',
            'location_booth' => $tenantData['LOCATION_BOOTH'] ?? '',
            'current_password_error' => '',
            'new_password_error' => '',
            'confirm_password_error' => '',
            'success_message' => '',
        ];
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = trim($_POST['current_password'] ?? '');
            $newPassword = trim($_POST['new_password'] ?? '');
            $confirmPassword = trim($_POST['confirm_password'] ?? '');
    
            if (empty($currentPassword)) {
                $data['current_password_error'] = 'Password saat ini tidak boleh kosong.';
            } elseif (!$this->tenantModel->verifyPassword($tenantId, $currentPassword)) {
                $data['current_password_error'] = 'Password saat ini salah.';
            }
    
            if (empty($newPassword)) {
                $data['new_password_error'] = 'Password baru tidak boleh kosong.';
            } elseif (strlen($newPassword) < 8) {
                $data['new_password_error'] = 'Password baru harus memiliki minimal 8 karakter.';
            }
    
            if (empty($confirmPassword)) {
                $data['confirm_password_error'] = 'Konfirmasi password tidak boleh kosong.';
            } elseif ($newPassword !== $confirmPassword) {
                $data['confirm_password_error'] = 'Password baru dan konfirmasi tidak cocok.';
            }
    
            if (empty($data['current_password_error']) && empty($data['new_password_error']) && empty($data['confirm_password_error'])) {
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
    
                if ($this->tenantModel->updatePassword($tenantId, $hashedPassword)) {
                    $data['success_message'] = 'Password berhasil diperbarui.';
                } else {
                    $data['current_password_error'] = 'Gagal memperbarui password. Silakan coba lagi.';
                }
            }
        }
    
        $this->view('templates/init');
        $this->view('templates/tenant_header');
        $this->view('tenant/settings', $data);
    }
    
    
    
    public function menu($action = 'view') {
        $this->checkLoggedIn();

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

        $this->view('templates/tenant_header');
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
        var_dump($updated);
        if ($updated) {
            return json_encode(['status' => 'success', 'message' => 'Menu status updated successfully!']);
        } else {
            return json_encode(['status' => 'error', 'message' => 'Failed to update menu status.']);
        }
    }
    
    public function logout() {
        $this->checkLoggedIn();
        session_destroy();
        header("Location: /Tenant");
        exit();
    }
}