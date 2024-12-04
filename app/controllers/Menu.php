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
        // Get all menus (no need to filter by location here)
        $data = [
            'menus' => $this->menuModel->getAllMenus(),
        ];

        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            $data['cart'] = $this->cartModel->getCartUser($user['id']);
        }

        // Pass the menus to the view
        $this->view('templates/header');
        $this->view('menu/menu', $data);
    }
}
