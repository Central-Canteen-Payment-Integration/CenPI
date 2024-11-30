<?php

class Home extends Controller {
    private $menuModel;
    private $cartModel;

    public function __construct() {
        $this->menuModel = $this->model('MenuModel');
        $this->cartModel = $this->model('CartModel');
    }

    public function index() {
        $data = [
            'menus' => $this->menuModel->getAllMenus(),
        ];
    
        if (isset($_SESSION['user_id'])) {
            $id_user = $_SESSION['user_id'];
            $data['id_user'] = $id_user; 
            $data['cart'] = $this->cartModel->getCartUser ($id_user);
        }

    
        $this->view('templates/header');
        $this->view('home/index', $data);
    }

    public function checkout() {
        $this->view('templates/header');
        $this->view('home/checkout');   
    }
}
