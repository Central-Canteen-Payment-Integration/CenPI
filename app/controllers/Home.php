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
    public function checkout(){
        $this->view('templates/header');
        $this->view('Home/checkout');   
    }
}
