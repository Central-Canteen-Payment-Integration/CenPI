<?php

class User extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('UserModel');
    }

    public function login() {
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->login($username, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['ID_USER'];
                $_SESSION['username'] = $user['USERNAME'];
                header('Location: /home');
                exit;
            } else {
                $data['error'] = 'Invalid username or password';
            }
        }

        $this->view('home/login_register', $data);
    }

    public function register() {
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if ($this->userModel->register($username, $password)) {
                header('Location: /user/login');
            } else {
                $data['error'] = 'Registration failed';
            }
        }

        $this->view('home/login_register', $data);
    }
}