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

    public function initialize() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Checkout');
            return;
        }

        $snapToken = '';
    
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
        $data['transaction'] = $this->trxModel->getTransaction($transactionId);

        if ($paymentOption === 'QRIS') {
            $dbDate = $data['transaction']['TRX_DATETIME'];
            $date = DateTime::createFromFormat('d-M-y h.i.s.u A', $dbDate);
            $formattedDate = $date->format('Y-m-d H:i:s') . ' +0700';
            $snapToken = $this->createSnap($transactionId, (int)$data['transaction']['TRX_PRICE'], $formattedDate);
            $this->trxModel->updateMidtransToken($transactionId, $snapToken);
            header("Location: /Checkout/qrisPayment/" . $snapToken);
        } else {
            $this->view('templates/init');
            $this->view('');
            return;
        }
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

    public function cashPayment($snapToken) {
        if (is_null($snapToken)) {
            header('Location: /Home/menu');
            exit();
        }

        $data['snapToken'] = $snapToken;

        $this->view('templates/init');
        $this->view('checkout/payment', $data);
    }

    private function createSnap($transactionId, $amount, $startTime) {
        $params = [
            'transaction_details' => [
                'order_id' => $transactionId,
                'gross_amount' => $amount,
            ],
            "expiry" => [
                "start_time" => $startTime,
                "unit" => "minutes",
                "duration" => 20
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