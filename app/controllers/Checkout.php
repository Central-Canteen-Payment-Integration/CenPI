<?php
use Ramsey\Uuid\Uuid;

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
        $orderId = Uuid::uuid4()->toString();;
        $amount = $_POST['amount'];

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            "custom_expiry" => [
                "expiry_duration" => 15,
                "unit" => "minute"
            ]
        ];
        
        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $data = [
                'snapToken' => $snapToken
            ];
            // return json_encode($data);
            $this->view('checkout/payment', $data);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}