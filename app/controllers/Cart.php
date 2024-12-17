<?php

class Cart extends Controller {
    private $cartModel;
    private $trxModel;

    public function __construct() {
        $this->cartModel = $this->model('CartModel');
        $this->trxModel = $this->model('TrxModel');
    }

    public function add() {
        $user = $_SESSION['user'];
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_menu = isset($_POST['id_menu']) ? $_POST['id_menu'] : 0;

            if ($id_menu) {
                $result = $this->cartModel->addCart($user['id'], $id_menu);
                if ($result) {
                    $cart = $this->cartModel->getCartUser($user['id']);
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
            $user = $_SESSION['user'];

            if ($id_cart) {
                $result = $this->cartModel->updateCart($id_cart, -1);
    
                if ($result) {
                    $cart = $this->cartModel->getCartUser($user['id']);
    
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
        $user = $_SESSION['user'];
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $result = $this->cartModel->clearCart($user['id']);
    
            if ($result) {
                $cart = $this->cartModel->getCartUser($user['id']);
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
    
    public function update() {
        if (isset($_POST['id_cart'])) {
            $id_cart = $_POST['id_cart'];
            $increase = $_POST['increase'];
            $qty = (int)$_POST['qty'];
            $user = $_SESSION['user'];
            $qty = $increase == 'true' ? $qty + 1 : ($qty == 1 ? -1 : $qty - 1);

            if ($id_cart) {
                $result = $this->cartModel->updateCart($id_cart, $qty);
    
                if ($result) {
                    $cart = $this->cartModel->getCartUser($user['id']);
    
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

    public function reorder() {
        $user = $_SESSION['user'];
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_transaction = isset($_POST['id_transaction']) ? $_POST['id_transaction'] : "";
            $validId = $this->trxModel->checkTransaction($id_transaction);

            if ($validId) {
                $reorder = $this->cartModel->reorder($id_transaction, $user['id']);
                if ($reorder) {
                    $cart = $this->cartModel->getCartUser($user['id']);
                    echo json_encode([
                        'status' => 'success',
                        'cart' => $cart
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Failed to Reorder.',
                    ]);
                }
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Invalid ID Transaction.'
                ]);
            }
            exit;
        }
    }
}