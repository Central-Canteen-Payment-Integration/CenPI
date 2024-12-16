<?php

class Tenant extends Controller
{
    private $tenantModel;

    public function __construct()
    {
        $this->tenantModel = $this->model('TenantModel');
    }

    private function checkLoggedIn()
    {
        if (!isset($_SESSION['tenant'])) {
            $data['error'] = "Please login First!";
            $this->view('templates/init');
            $this->view('tenant/login_register', $data);
            exit;
        }
    }

    public function login()
    {
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

    public function register()
    {
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
                $existingUsers = $this->tenantModel->findUserByUsernameOrEmail($username, $email);
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

    public function index()
    {
        $this->checkLoggedIn();

        $tenantId = $_SESSION['tenant']['id'];

        $startDate = date('d-m-Y');
        $endDate = date('d-m-Y');

        $data = $this->tenantModel->getDashboardData($tenantId, $startDate, $endDate);


        $this->view('templates/init');
        $this->view('templates/tenant_header');
        $this->view('tenant/index', $data);
    }

    public function getAnalytics($startDate, $endDate)
    {
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


    public function orderlist()
    {
        $this->checkLoggedIn();
        $this->view('templates/init');
        $this->view('templates/tenant_header');
        $this->view('tenant/orderlist');
    }

    public function crudmenu()
    {
        try {
            $this->checkLoggedIn();

            $tenant_id = $_SESSION['tenant']['id'] ?? null;
            if (!$tenant_id) {
                throw new Exception("Tenant ID not found in session.");
            }

            $this->tenantModel = $this->model('TenantModel');
            $menus = $this->tenantModel->getMenusByTenant($tenant_id);

            error_log("Menus Data: " . print_r($menus, true));


            $data = [
                'page' => 'Menu - CenPI',
                'menus' => $menus
            ];

            // Load Views
            $this->view('templates/tenant_header');
            $this->view('templates/init', $data);
            $this->view('tenant/crudmenu', $data);
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            die("Error fetching menus: " . $e->getMessage());
        }
    }

    public function historytransaction()
    {
        $this->checkLoggedIn();
        $this->view('templates/init');
        $this->view('templates/tenant_header');
        $this->view('tenant/historytransaction');
    }

    public function report()
    {
        $this->checkLoggedIn();
        $this->view('templates/init');
        $this->view('templates/tenant_header');
        $this->view('tenant/report');
    }

    public function settings()
    {
        $this->checkLoggedIn();

        $tenantId = $_SESSION['tenant']['id'];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tenantName = htmlspecialchars($_POST['tenant_name'] ?? '');
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';


            if (empty($tenantName)) {
                $data['error'] = 'Nama Tenant tidak boleh kosong.';
                var_dump($data['error']);
            } elseif (!empty($newPassword) && $newPassword !== $confirmPassword) {
                $data['error'] = 'Password baru dan konfirmasi tidak cocok.';
                var_dump($data['error']);
            } else {
                $tenant = $this->tenantModel->getTenantById($tenantId);
                if (!password_verify($currentPassword, $tenant['PASSWORD'])) {
                    $data['error'] = 'Password saat ini salah.';
                    var_dump($data['error']);
                } else {
                    $hashedPassword = !empty($newPassword) ? password_hash($newPassword, PASSWORD_BCRYPT) : null;

                    $isUpdated = $this->tenantModel->updateTenantProfile($tenantId, $tenantName, $hashedPassword);

                    if ($isUpdated) {
                        $data['success'] = 'Profil berhasil diperbarui.';
                        var_dump($data['error']);
                    } else {
                        $data['error'] = 'Gagal memperbarui profil.';
                        var_dump($data['error']);
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
        $this->view('templates/tenant_header');
        $this->view('tenant/settings', $data);
    }

    public function addMenu()
    {
        $this->checkLoggedIn();

        if (!isset($_SESSION['tenant']['id'])) {
            echo json_encode(['status' => 'error', 'message' => 'Tenant ID is missing']);
            return;
        }

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

        $result = $this->tenantModel->addMenu($id_tenant, $name, $price, $pkg_price, $image_path, $menu_type, $id_category);

        if ($result['status'] === 'success') {
            header('Location: /tenant/crudmenu');
            exit;
        } else {
            header('Location: /tenant/menu?error=' . urlencode($result['message']));
            exit;
        }
    }




    private function uploadImage($image)
    {
        if ($image['error'] == 0) {
            $targetDir = "uploads/";
            $targetFile = $targetDir . uniqid() . "-" . basename($image["name"]);
            if (move_uploaded_file($image["tmp_name"], $targetFile)) {
                return $targetFile;
            }
        }
        return null;
    }
    public function updateMenuStatus()
    {
        $menuId = isset($_POST['menu_id']) ? $_POST['menu_id'] : null;
        $currentStatus = isset($_POST['current_status']) ? $_POST['current_status'] : null;
    
        if (empty($menuId) || !in_array($currentStatus, ['0', '1'])) {
            $_SESSION['error'] = 'Invalid data!';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            return; 
        }
    
        $newStatus = $currentStatus == '1' ? 0 : 1;
    
        $tenantModel = new TenantModel();
        $updated = $tenantModel->updateMenuStatus($menuId, $newStatus);
    
        if ($updated) {
            $_SESSION['success'] = 'Menu status updated successfully!';
        } else {
            $_SESSION['error'] = 'Failed to update menu status.';
        }
    
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        return;
    }
    



    public function logout()
    {
        $this->checkLoggedIn();
        session_destroy();
        header("Location: /Tenant");
        exit();
    }
}
