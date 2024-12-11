<?php

use Ramsey\Uuid\Uuid;

class TrxModel extends Model
{
    public function createTransactionWithDetails($userId, $orderType, $paymentOption) {

        $transactionId =  Uuid::uuid7()->toString();;
        $takeaway = ($orderType === 'TAKEAWAY') ? 1 : 0;
        $paymentOption = strtolower($paymentOption);
        $takeaway = strtolower($takeaway);

        try {
            $this->db->beginTransaction();

            $this->db->query("CALL process_cart_to_transaction(:p_id_transaction, :p_id_user, :p_trx_method, :p_takeaway)");
            
            $this->db->bind(':p_id_transaction', $transactionId);
            $this->db->bind(':p_id_user', $userId);
            $this->db->bind(':p_trx_method', $paymentOption);
            $this->db->bind(':p_takeaway', $takeaway);

            $this->db->execute();

            return $transactionId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Failed to create transaction: " . $e->getMessage());
        }
    }

    public function getTransactionAmount($transactionId) {
        $query = "SELECT trx_price FROM TRANSACTION WHERE id_transaction = :id_transaction";
        $this->db->query($query);
        $this->db->bind(':id_transaction', $transactionId);

        $result = $this->db->single();
        
        return $result ? (int)$result['TRX_PRICE'] : 0;
    }

    public function updateMidtransToken($transactionId, $snapToken) {
        try {
            $query = "UPDATE TRANSACTION SET midtrans_token = :midtrans_token WHERE id_transaction = :id_transaction";
            $this->db->query($query);
            
            $this->db->bind(':midtrans_token', $snapToken);
            $this->db->bind(':id_transaction', $transactionId);
            
            if ($this->db->execute()) {
                $this->db->commit();
                return true;
            } else {
                $this->db->rollBack();
                return false;
            }
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Failed to update midtrans token: " . $e->getMessage());
        }
    }
}