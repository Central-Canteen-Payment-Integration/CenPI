<?php

class Home extends Controller {
    private $menuModel;

    public function __construct() {
        $this->menuModel = $this->model('MenuModel');
    }

    public function index() {
        $data = [
            'menus' => $this->menuModel->getAllMenus()
        ];
        $this->view('templates/header');
        $this->view('Home/index', $data);
    }
    
    public function logout() {
        session_destroy();
        header("Location: /Home");
        exit();
    }
}
