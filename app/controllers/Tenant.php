<?php

class Tenant extends Controller {
    private $tenantModel;

    public function __construct() {
        $this->tenantModel = $this->model('TenantModel');
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
    
    public function index() {
        $this->checkLoggedIn();
        $this->view('templates/init');
        $this->view('templates/tenant_header');
        $this->view('tenant/index');
    }

    public function orderlist() {
        $this->checkLoggedIn();
        $this->view('templates/init');
        $this->view('templates/tenant_header');
        $this->view('tenant/orderlist');
    }

    public function menu() {
        $this->checkLoggedIn();
        $this->view('templates/init');
        $this->view('templates/tenant_header');
        $this->view('tenant/crudmenu');
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

    public function settings() {
        $this->checkLoggedIn();
        $this->view('templates/init');
        $this->view('templates/tenant_header');
        $this->view('tenant/settings');
    }

    public function logout() {
        $this->checkLoggedIn();
        session_destroy();
        header("Location: /Tenant");
        exit();
    }
}