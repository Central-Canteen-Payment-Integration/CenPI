<?php

class Order extends Controller
{
    private $orderModel;

    public function __construct()
    {
        $this->orderModel = $this->model('OrderModel');
    }
    public function activeOrders()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user'])) {
            echo json_encode([]);
            return;
        }

        $userId = $_SESSION['user']['id'];
        $orders = $this->orderModel->getActiveOrdersByUser($userId);

        $formattedOrders = [];
        foreach ($orders as $order) {
            if (!isset($order['TRX_DATETIME']) || !isset($order['TRX_PRICE']) || !isset($order['ID_TRANSACTION'])) {
                error_log("Missing data in active order: " . json_encode($order));
                continue;
            }

            $trxDateTime = DateTime::createFromFormat('d-M-y h.i.s.u A', $order['TRX_DATETIME']);
            if (!$trxDateTime) {
                error_log("Invalid TRX_DATETIME format: " . $order['TRX_DATETIME']);
                continue;
            }

            $trxDateFormatted = $trxDateTime->format('d-m-Y');
            $trxDateNoDash = $trxDateTime->format('dmY');

            $details = $this->orderModel->getOrderDetails($order['ID_TRANSACTION']);
            
            $formattedDetails = [];
            foreach ($details as $detail) {
                $formattedDetails[] = [
                    'menu_name' => $detail['MENU_NAME'],
                    'tenant_name' => $detail['TENANT_NAME'],
                    'qty' => (int)$detail['QTY'],
                    'qty_price' => (int)$detail['QTY_PRICE'],
                    'pkg_price' => (int)$detail['PKG_PRICE'],
                    'notes' => $detail['NOTES'],
                    'status' => $detail['STATUS']
                ];
            }

            $formattedOrders[] = [
                'real_id' => $order['ID_TRANSACTION'],
                'id_transaction' => 'TRX' . $trxDateNoDash,
                'trx_price' => (int)$order['TRX_PRICE'],
                'trx_date' => $trxDateFormatted,
                'trx_status' => $order['TRX_STATUS'],
                'details' => $formattedDetails
            ];
        }

        echo json_encode($formattedOrders);
        error_log(json_encode($formattedOrders));
    }

    public function transactionHistory()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user'])) {
            echo json_encode([]);
            return;
        }

        $userId = $_SESSION['user']['id'];
        $orders = $this->orderModel->getHistoryOrdersByUser($userId);

        $formattedOrders = [];
        foreach ($orders as $order) {
            if (!isset($order['TRX_DATETIME']) || !isset($order['TRX_PRICE']) || !isset($order['ID_TRANSACTION'])) {
                error_log("Missing data in transaction history: " . json_encode($order));
                continue;
            }

            $trxDateTime = DateTime::createFromFormat('d-M-y h.i.s.u A', $order['TRX_DATETIME']);
            if (!$trxDateTime) {
                error_log("Invalid TRX_DATETIME format: " . $order['TRX_DATETIME']);
                continue;
            }

            $trxDateFormatted = $trxDateTime->format('d-m-Y');
            $trxDateNoDash = $trxDateTime->format('dmY');

            $details = $this->orderModel->getOrderDetails($order['ID_TRANSACTION']);

            $formattedDetails = [];
            foreach ($details as $detail) {
                $formattedDetails[] = [
                    'menu_name' => $detail['MENU_NAME'],
                    'tenant_name' => $detail['TENANT_NAME'],
                    'qty' => (int)$detail['QTY'],
                    'qty_price' => (int)$detail['QTY_PRICE'],
                    'pkg_price' => (int)$detail['PKG_PRICE'],
                    'notes' => $detail['NOTES'],
                    'status' => $detail['STATUS']
                ];
            }

            $formattedOrders[] = [
                'real_id' => $order['ID_TRANSACTION'],
                'id_transaction' => 'TRX' . $trxDateNoDash,
                'trx_price' => (int)$order['TRX_PRICE'],
                'trx_date' => $trxDateFormatted,
                'trx_status' => $order['TRX_STATUS'],
                'details' => $formattedDetails
            ];
        }

        echo json_encode($formattedOrders);
        error_log(json_encode($formattedOrders));
    }
}
