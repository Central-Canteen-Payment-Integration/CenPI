<?php

class Home extends Controller {
    private $menuModel;

    public function __construct() {
        $this->menuModel = $this->model('MenuModel');
    }

    public function index() {
        $data = [
            'menus' => $this->menuModel->getAllMenus(),
        ];
        $this->view('templates/header');
        $this->view('Home/index', $data);
    }

    public function cart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $menu_id = $_POST['menu_id'];
            $menu_name = $_POST['menu_name'];
            $menu_price = $_POST['menu_price'];

            $_SESSION['cart'][] = [
                'id' => $menu_id,
                'name' => $menu_name,
                'price' => $menu_price
            ];
            exit();
        }
    }

    public function checkout() {
        $this->view('templates/header');
        $this->view('Home/checkout');   
    }
}
