<?php
class Checkout extends Controller {
    private $cartModel;

    public function __construct() {
        $this->cartModel = $this->model('CartModel');
    }

    public function index() {
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            $data['cart'] = $this->cartModel->getCartUser($user['id']);
        } else {
            
        }
        $this->view('templates/focus_header');
        $this->view('checkout/bak', $data);
    }

    public function processPayment() {
        $orderId = uniqid('order-');
        $amount = $_POST['amount'];
        $customerDetails = [
            'first_name' => 'test',
            'last_name' => 'jose',
            'email' => 'test@gmail.com',
            'phone' => '01238018302',
        ];

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => $customerDetails,
        ];
        
        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $data = [
                'snapToken' => $snapToken
            ];
            $this->view('checkout/payment', $data);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}