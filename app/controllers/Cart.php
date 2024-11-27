<?php

class Cart extends Controller {
    private $cartModel;

    public function __construct() {
        $this->cartModel = $this->model('CartModel');
    }

    public function add() {
        $id_user = $_SESSION['user_id'];
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_menu = isset($_POST['id_menu']) ? $_POST['id_menu'] : 0;

            if ($id_menu) {
                $result = $this->cartModel->addCart($id_user, $id_menu);
                if ($result) {
                    $cart = $this->cartModel->getCartUser($id_user);
                    echo json_encode([
                        'status' => 'success',
                        'cart' => $cart
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Failed to add item to cart.'
                    ]);
                }
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Invalid menu ID.'
                ]);
            }
            exit;
        }
    }

    public function delete() {
        if (isset($_POST['id_cart'])) {
            $id_cart = $_POST['id_cart'];
            $id_user = $_SESSION['user_id'];

            if ($id_cart) {
                $result = $this->cartModel->updateCart($id_cart, -1);
    
                if ($result) {
                    $cart = $this->cartModel->getCartUser($id_user);
    
                    echo json_encode([
                        'status' => 'success',
                        'cart' => $cart
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Failed to delete item from cart.'
                    ]);
                }
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Invalid menu ID.'
                ]);
            }
            exit;
        }
    
        echo json_encode([
            'status' => 'error',
            'message' => 'Menu ID not provided.'
        ]);
        exit;
    }

    public function clear() {
        $id_user = $_SESSION['user_id'];
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $result = $this->cartModel->clearCart($id_user);
    
            if ($result) {
                $cart = $this->cartModel->getCartUser($id_user);
                echo json_encode([
                    'status' => 'success',
                    'cart' => $cart
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to clear the cart.'
                ]);
            }
            exit;
        }
    }
    
    
}