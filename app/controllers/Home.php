<?php

class Home extends Controller {
    private $menuModel;
    private $cartModel;

    public function __construct() {
        $this->menuModel = $this->model('MenuModel');
        $this->cartModel = $this->model('CartModel');
    }

    public function index() {
        $id_user = $_SESSION['user_id'];
        
        $data = [
            'menus' => $this->menuModel->getAllMenus(),
            'cart' => $this->cartModel->getCartUser($id_user)
        ];
        $this->view('templates/header');
        $this->view('Home/index', $data);
    }

    public function checkout() {
        $this->view('templates/header');
        $this->view('Home/checkout');   
    }
}
