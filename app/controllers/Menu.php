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
            'menus' => $this->menuModel->getAllMenus(),
            'cart' => ''
        ];
        
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            $data['cart'] = $this->cartModel->getCartUser($user['id']);
        }
        // echo '<pre>'; var_dump($data['menus']); echo '</pre>';
        $this->view('templates/header');
        $this->view('home/menu', $data);
    }
}
