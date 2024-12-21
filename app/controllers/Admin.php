<?php

class Admin extends Controller
{
    private $adminModel;

    public function __construct()
    {
        $this->adminModel = $this->model('AdminModel');
    }

    private function checkLoggedIn()
    {
        if (!isset($_SESSION['admin'])) {
            $data['error'] = "Please login First!";
            $this->view('templates/init');
            $this->view('admin/login', $data);
            exit;
        }
    }

    public function login()
    {
        if (isset($_SESSION['admin'])) {
            header('Location: /Admin/index');
            exit;
        }

        $data = [
            'error' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->adminModel->login($username, $password);

            if ($user) {
                $_SESSION['admin'] = [
                    'id' => $user['ID_ADMIN'],
                    'username' => $user['USERNAME'],
                ];
                header('Location: /Admin');
                exit;
            } else {
                $data['error'] = 'Invalid username or password';
            }
        }

        $this->view('templates/init');
        $this->view('admin/login', $data);
    }

    public function index()
    {
        $this->checkLoggedIn();

        $search = isset($_POST['search']) ? $_POST['search'] : '';
        $data = [
            'tenants' => $this->adminModel->getAllTenants($search)
        ];

        $this->view('templates/init');
        $this->view('templates/admin_header');
        $this->view('admin/index', $data);
    }

    public function toggleStatus($tenantId)
    {
        $tenant = $this->adminModel->getTenantById($tenantId);

        if ($tenant) {
            $newStatus = ($tenant['ACTIVE'] == 1) ? 0 : 1;
            $this->adminModel->updateTenantStatus($tenantId, $newStatus);
        }

        header('Location: /admin/index');
        exit;
    }

    public function cash()
    {
        $this->checkLoggedIn();

        $data['transactions'] = $this->adminModel->getAllTransactions();

        $this->view('templates/init');
        $this->view('templates/admin_header');
        $this->view('admin/cash', $data);
    }

    public function terimaUang($transactionId)
    {
        if ($this->adminModel->updateTransactionStatus($transactionId)) {
            header('Location: /admin/cash');
            exit;
        } else {
            echo "Failed to update the transaction status.";
        }
    }
}
