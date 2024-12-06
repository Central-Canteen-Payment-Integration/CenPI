<?php

class Menu extends Controller
{
    private $menuModel;
    private $cartModel;

    public function __construct()
    {
        $this->menuModel = $this->model('MenuModel');
        $this->cartModel = $this->model('CartModel');
    }

    public function index()
    {
        $data = [
            'page' => 'Menu - CenPI',
            'cart' => null,
            'menus' => $this->menuModel->getAllMenus(),
        ];

        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            $data['cart'] = $this->cartModel->getCartUser ($user['id']); 
        } else {
            $data['cart'] = [];
        }

        $this->view('templates/init', $data);
        $this->view('templates/header');
        $this->view('home/menu', $data);
    }
}
