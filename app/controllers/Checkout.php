<?php
class Checkout extends Controller {
    private $cartModel;
    private $trxModel;

    public function __construct() {
        $this->cartModel = $this->model('CartModel');
        $this->trxModel = $this->model('TrxModel');
    }

    public function index() {
        $data = [
            'page' => 'Checkout - CenPI',
            'cart' => []
        ];

        if (isset($_SESSION['user']) && isset($_SESSION['user']['id'])) {
            $userId = $_SESSION['user']['id'];
            $data['cart'] = $this->cartModel->getCartUser($userId);
        }

        $this->view('templates/init');
        $this->view('templates/focus_header');
        $this->view('checkout/index', $data);
    }

    public function processPayment() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Checkout');
            return;
        }

        $snapToken = isset($_POST['snapToken']) ? $_POST['snapToken'] : null;
    
        if ($snapToken == null) {
            if (isset($_SESSION['user']) && isset($_SESSION['user']['id'])) {
                $userId = $_SESSION['user']['id'];
                $data['cart'] = $this->cartModel->getCartUser($userId);
            }
            $orderType = isset($_POST['order-type']) ? strtoupper($_POST['order-type']) : null;
            $paymentOption = isset($_POST['payment-option']) ? strtoupper($_POST['payment-option']) : null;
        
            if (is_null($orderType) || is_null($paymentOption)) {
                echo json_encode(['error' => 'Request error']);
                return;
            }

            $transactionId = $this->trxModel->createTransactionWithDetails($userId, $orderType, $paymentOption);
            $totalAmount = $this->trxModel->getTransactionAmount($transactionId);
            if ($paymentOption === 'QRIS') {
                $snapToken = $this->createSnap($transactionId, $totalAmount);
                $this->trxModel->updateMidtransToken($transactionId, $snapToken);
            } else {
                $this->view('templates/init');
                $this->view('');
                return;
            }
        }

        header("Location: /Checkout/qrisPayment/" . $snapToken);
    }

    public function qrisPayment($snapToken) {
        if (is_null($snapToken)) {
            header('Location: /Home/menu');
            exit();
        }

        $data['snapToken'] = $snapToken;

        $this->view('templates/init');
        $this->view('checkout/payment', $data);
    }

    private function createSnap($transactionId, $amount) {
        $params = [
            'transaction_details' => [
                'order_id' => $transactionId,
                'gross_amount' => $amount,
            ],
            "page_expiry" => [
                "duration" => 1,
                "unit" => "hours"
            ]
        ];
        
        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return $snapToken;
        } catch (Exception $e) {
            return ['error' => 'Error: ' . $e->getMessage()];
        }
    }
}