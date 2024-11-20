<?php

class Home extends Controller {

    public function index() {
        if (isset($_SESSION['user_id'])) {
            $username = $_SESSION['username'];
            $data['username'] = $username;
            $this->view('templates/header');
            $this->view('home/index', $data);
        } else {
            $this->view('templates/header');
            $this->view('home/index');
        }
    }

    public function logout() {
        session_destroy();
        header("Location: /Home");
        exit();
    }
}
