<?php

class Tenant extends Controller
{
    private $tenantModel;
    private $analModel;

    public function __construct()
    {
        $this->tenantModel = $this->model('TenantModel');
        $this->analModel = $this->model('AnalModel');
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
        // Assuming the tenant ID is stored in the session
        $tenantId = $_SESSION['tenant']['id'];

        // Ensure startDate and endDate are passed as strings, if not set default
        $startDate = isset($_GET['startDate']) ? $_GET['startDate'] : date('d-m-Y');
        $endDate = isset($_GET['endDate']) ? $_GET['endDate'] : date('d-m-Y');

        // Debug: Log received dates
        error_log("Received dates index: Start Date - " . $startDate . ", End Date - " . $endDate);

        // Get data from the model
        $data = $this->analModel->getDashboardData($tenantId, $startDate, $endDate);

        // Debug: Log the data received
        error_log("Dashboard Data: " . var_export($data, true));

        // Pass data to the view
        $this->checkLoggedIn();
        $this->view('templates/init');
        $this->view('templates/tenant_header');
        $this->view('tenant/index', $data);
    }

    public function applyFilter()
    {
        // Assuming tenant ID is stored in the session
        $tenantId = $_SESSION['tenant']['id'];

        // Get startDate and endDate from GET parameters
        $startDate = $_GET['startDate'] ?? date(format: 'd-m-Y');
        $endDate = $_GET['endDate'] ?? date('d-m-Y');

        // Debug: Log the received dates
        error_log("Received dates filter: Start Date - " . $startDate . ", End Date - " . $endDate);

        // Get data from the model
        $data = $this->analModel->getDashboardData($tenantId, $startDate, $endDate);

        // Debug: Log the data received
        error_log("Dashboard Data in applyFilter: " . var_export($data, true));

        // Return the data as JSON
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

    public function menu()
    {
        $this->checkLoggedIn();
        $this->view('templates/init');
        $this->view('templates/tenant_header');
        $this->view('tenant/crudmenu');
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
    
    
    
    

    public function logout()
    {
        $this->checkLoggedIn();
        session_destroy();
        header("Location: /Tenant");
        exit();
    }
}
