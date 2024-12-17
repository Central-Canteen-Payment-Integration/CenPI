<?php
use WebSocket\Client;

class Midtrans extends Controller {
    private $trxModel;

    public function __construct() {
        $this->trxModel = $this->model('TrxModel');
    }

    public function notification() {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (isset($data['transaction_id'])) {
            $transactionStatus = $data['transaction_status'];
            $status_code = $data['status_code'];
            $id_transaction = $data['order_id'];
            $signatureKey = $data['signature_key'];
            $grossAmount = $data['gross_amount'];

            if (!$this->validateSignature($id_transaction, $status_code, $grossAmount, $signatureKey)) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Invalid signature']);
                return;
            }

            switch ($transactionStatus) {
                case 'expire':
                    $this->trxModel->updateOrderStatus($id_transaction, 'Expired');
                    echo json_encode(['status' => 'expired', 'message' => 'Transaction expired']);
                    break;

                case 'settlement':
                    $this->trxModel->updateOrderStatus($id_transaction , 'Pending');
                    $this->alertTenant($id_transaction);
                    echo json_encode(['status' => 'success', 'message' => 'Transaction successful']);
                    break;

                case 'cancel':
                    echo json_encode(['status' => 'canceled', 'message' => 'Transaction canceled']);
                    break;
                
                case 'pending':
                    echo json_encode(['status' => 'pending', 'message' => 'Transaction pending']);
                    break;

                default:
                    echo json_encode(['status' => 'error', 'message' => 'Unknown transaction status']);
                    break;
            }

            http_response_code(200);

        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid notification data']);
        }
    }

    private function validateSignature($order_id, $status_code, $grossAmount, $signatureKey) {
        $serverKey = 'SB-Mid-server-i8ojvKHk0WO3_AwTtRYBNlGf';
        $signature = hash('sha512', $order_id . $status_code . $grossAmount . $serverKey);
        return $signature === $signatureKey;
    }
   
    private function alertTenant($id_transaction) {
        $tenant = $this->trxModel->getTenant($id_transaction);

        $webSocketUrl = "wss://websocket.cenpi.my.id/?client_id=" . rand();
        $client = new WebSocket\Client($webSocketUrl);
    
        foreach ($tenant as $x) {
            $message = json_encode([
                'client_id' => $x['ID_TENANT'],
                'message' => 'New Orders.'
            ]);
    
            $client->send($message);
        }

        $client->close();
    }
}