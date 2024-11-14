<?php

class Home extends Controller {

    public function index() {
        $this->view('templates/header');
        $this->view('home/index');
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $userModel = $this->model('HomeModel');
            $user = $userModel->validateLogin($username, $password);

            if ($user) {
                $_SESSION['user'] = $user;
                $this->view('templates/header');
                $this->view('home/index');
                exit();
            } else {
                $error = "Invalid username or password";
                $this->view('templates/header');
                $this->view('home/index');
            }
        } else {
            $this->view('templates/header');
            $this->view('home/index');
        }
    }

    public function logout() {
        session_destroy();
        header("Location: /home");
        exit();
    }
}
