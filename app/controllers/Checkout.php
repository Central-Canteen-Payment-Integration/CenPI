<?php
class Checkout extends Controller
{
    private $cartModel;
    private $trxModel;

    public function __construct()
    {
        $this->cartModel = $this->model('CartModel');
        $this->trxModel = $this->model('TrxModel');
    }

    public function index()
    {
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

    public function initialize()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Checkout');
            return;
        }

        if (isset($_SESSION['user']) && isset($_SESSION['user']['id'])) {
            $userId = $_SESSION['user']['id'];
            $data['cart'] = $this->cartModel->getCartUser($userId);

            if (empty($data['cart']) || count($data['cart']) === 0) {
                $_SESSION['error'] = 'Cart is empty';
                header('Location: /Checkout');
                return;
            }
        }

        $orderType = isset($_POST['order-type']) ? strtoupper($_POST['order-type']) : null;
        $paymentOption = isset($_POST['payment-option']) ? strtoupper($_POST['payment-option']) : null;

        if (is_null($orderType) || is_null($paymentOption)) {
            $_SESSION['error'] = 'Please select a payment option.';
            header('Location: /Checkout');
            return;
        }
        $inactive = $this->trxModel->checkClosedTenantsorMenu($userId);
        if (count($inactive) > 0) {
            $_SESSION['show_modal'] = true;
            $_SESSION['inactive'] = $inactive;
            header('Location: /Checkout');
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
            $this->trxModel->updateCashPayment($transactionId);
            header("Location: /Checkout/cashPayment/");
            return;
        }
    }

    public function qrisPayment($snapToken)
    {
        if (is_null($snapToken)) {
            header('Location: /Home/menu');
            exit();
        }

        $data['snapToken'] = $snapToken;

        $this->view('templates/init');
        $this->view('checkout/payment', $data);
    }

    public function cashPayment() {
        if (!isset($_SESSION['user']['id'])) {
            header('Location: /user/login');
            exit();
        }
    
        $userId = $_SESSION['user']['id'];
    
        $this->checkUnpaidCashTransactions();
    
        $transaction = $this->trxModel->getActiveTransaction($userId);
    
        if ($transaction && isset($transaction['TRX_STATUS'])) {
            error_log("Transaction status: " . $transaction['TRX_STATUS']);
            if ($transaction['TRX_STATUS'] === 'Completed') {
                header('Location: /user/order');
                exit();
            }
        }
    
        $this->view('templates/init');
        $this->view('checkout/cashpay', ['userId' => $userId]);
    }
    public function checkUnpaidCashTransactions()
    {
        if (!isset($_SESSION['user']['id'])) {
            header('Location: /user/login');
            exit();
        }

        $userId = $_SESSION['user']['id'];

        $hasUnpaid = $this->trxModel->hasUnpaidCashTransactions($userId);

        if (!$hasUnpaid) {
            header('Location: /user/order');
            exit();
        }
    }

    public function checkTransactionStatus() {
        if (!isset($_SESSION['user']['id'])) {
            header('Location: /user/login');
            exit();
        }
    
        $userId = $_SESSION['user']['id'];
        $transaction = $this->trxModel->getActiveTransaction($userId);
    
        if (!$transaction) {
            echo json_encode(['status' => 'error', 'message' => 'Transaction not found']);
            return;
        }
        echo json_encode(['status' => 'success', 'trx_status' => $transaction['TRX_STATUS']]);
    }
    
    private function createSnap($transactionId, $amount, $startTime)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $transactionId,
                'gross_amount' => $amount,
            ],
            "expiry" => [
                "start_time" => $startTime,
                "unit" => "minutes",
                "duration" => 30
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
