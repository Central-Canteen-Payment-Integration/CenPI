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
            $this->db->commit();

            return $transactionId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Failed to create transaction: " . $e->getMessage());
        }
    }

    public function getTransaction($id_transaction) {
        $sql = "SELECT * FROM TRANSACTION WHERE id_transaction = :id_transaction";
        $this->db->query($sql);
        $this->db->bind(':id_transaction', $id_transaction);
        
        return $this->db->single();
    }

    public function checkTransaction($id_transaction) {
        try {
            $sql = "SELECT COUNT(*) AS count FROM TRANSACTION WHERE id_transaction = :id_transaction";
            $this->db->query($sql);
            $this->db->bind(':id_transaction', $id_transaction);
            
            $result = $this->db->single();
            if ($result && isset($result['COUNT'])) {
                return $result['COUNT'] > 0;
            } else {
                return false;
            }
        } catch (Exception $e) {
            error_log("Error in checkTransaction: " . $e->getMessage());
            return false;
        }
    }

    public function getTransactionByUserId($userId) {
        $sql = "SELECT 
                    t.id_transaction,
                    t.trx_price,
                    t.trx_datetime,
                    t.takeaway,
                    t.trx_method,
                    t.midtrans_token,
                    t.trx_status,
                    td.qty,
                    td.qty_price,
                    td.pkg_price,
                    td.notes,
                    td.status AS transaction_detail_status,
                    m.name AS menu_name,
                    m.image_path AS menu_image_path,
                    tn.tenant_name,
                    tn.image_path AS tenant_image_path,
                    tn.location_name,
                    tn.location_booth
                FROM 
                    TRANSACTION t
                JOIN 
                    TRANSACTION_DETAIL td ON t.id_transaction = td.id_transaction
                JOIN 
                    MENU m ON td.id_menu = m.id_menu
                JOIN 
                    TENANT tn ON m.id_tenant = tn.id_tenant
                WHERE 
                    t.id_user = :id_user
                ORDER BY 
                    t.trx_datetime DESC";
        $this->db->query($sql);
        $this->db->bind(':id_user', $userId);
    
        $results = $this->db->resultSet();
    
        $transactions = [];
    
        foreach ($results as $row) {
            $transactionId = $row['ID_TRANSACTION'];
    
            if (!isset($transactions[$transactionId])) {
                $originalDateTime = $row['TRX_DATETIME'];
                $dateTime = DateTime::createFromFormat('d-M-y h.i.s.u A', $originalDateTime);
                $formattedDateTime = $dateTime->format('d/m/Y H:i');
                $transactions[$transactionId] = [
                    'ID_TRANSACTION' => $row['ID_TRANSACTION'],
                    'TRX_PRICE' => $row['TRX_PRICE'],
                    'TRX_DATETIME' => $formattedDateTime,
                    'TAKEAWAY' => $row['TAKEAWAY'],
                    'TRX_METHOD' => $row['TRX_METHOD'],
                    'MIDTRANS_TOKEN' => $row['MIDTRANS_TOKEN'],
                    'TRX_STATUS' => $row['TRX_STATUS'],
                    'DETAILS' => []
                ];
            }
    
            $transactions[$transactionId]['DETAILS'][] = [
                'QTY' => $row['QTY'],
                'QTY_PRICE' => $row['QTY_PRICE'],
                'PKG_PRICE' => $row['PKG_PRICE'],
                'NOTES' => $row['NOTES'],
                'TRANSACTION_DETAIL_STATUS' => $row['TRANSACTION_DETAIL_STATUS'],
                'MENU_NAME' => $row['MENU_NAME'],
                'MENU_IMAGE_PATH' => $row['MENU_IMAGE_PATH'],
                'TENANT_NAME' => $row['TENANT_NAME'],
                'TENANT_IMAGE_PATH' => $row['TENANT_IMAGE_PATH'],
                'LOCATION_NAME' => $row['LOCATION_NAME'],
                'LOCATION_BOOTH' => $row['LOCATION_BOOTH']
            ];
        }
    
        return $transactions;
    }
    

    public function updateMidtransToken($transactionId, $snapToken) {
        try {
            $this->db->beginTransaction();
            
            $sql = "UPDATE TRANSACTION SET midtrans_token = :midtrans_token WHERE id_transaction = :id_transaction";
            $this->db->query($sql);
            
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

    public function updateCashPayment($transactionId) {
        try {
            $this->db->beginTransaction();
    
            $sql = "UPDATE TRANSACTION SET trx_status = 'Unpaid' WHERE id_transaction = :id_transaction";
            $this->db->query($sql);
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
            throw new Exception("Failed to update transaction status: " . $e->getMessage());
        }
    }
    

    public function hasUnpaidCashTransactions($userId) {
        try {
            $sql = "SELECT COUNT(*) AS count
                    FROM transaction
                    WHERE trx_status = 'Unpaid' AND id_user = :id_user";
            $this->db->query($sql);
            $this->db->bind(':id_user', $userId);
            $result = $this->db->single();
    
            return $result['COUNT'] > 0;
        } catch (Exception $e) {
            error_log("Exception in hasUnpaidCashTransactions: " . $e->getMessage());
            return false;
        }
    }
    
    public function getActiveTransaction($userId) {
        $this->db->query("
            SELECT * 
            FROM (
                SELECT * 
                FROM transaction 
                WHERE id_user = :id_user AND (trx_status = 'Unpaid' OR trx_status = 'Completed')
                ORDER BY trx_datetime DESC
            ) 
            WHERE ROWNUM = 1
        ");
        $this->db->bind(':id_user', $userId);
        
        $result = $this->db->single();
        error_log("Transaction result: " . print_r($result, true));
        
        return $result;
    }

    public function checkExpiredOrder($userId) {
        try {
            $this->db->beginTransaction();
    
            $sql = "UPDATE transaction
                    SET trx_status = 'Cancelled'
                    WHERE id_user = :id_user
                    AND trx_status = 'Unpaid'
                    AND trx_datetime <= SYSTIMESTAMP - INTERVAL '30' MINUTE";
            
            $this->db->query($sql);
            $this->db->bind(':id_user', $userId);
            
            if ($this->db->execute()) {
                $this->db->commit();
                return true;
            } else {
                $this->db->rollBack();
                return false;
            }
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Failed to update expired orders: " . $e->getMessage());
        }
    }

    public function updateOrderStatus($id_transaction, $status) {
        try {
            $this->db->beginTransaction();
    
            $sql = "UPDATE transaction
                    SET trx_status = :status
                    WHERE id_transaction = :id_transaction";
            
            $this->db->query($sql);
            $this->db->bind(':id_transaction', $id_transaction);
            $this->db->bind(':status', $status);
            
            if ($this->db->execute()) {
                $this->db->commit();
                return true;
            } else {
                $this->db->rollBack();
                return false;
            }
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Failed to update expired orders: " . $e->getMessage());
        }
    }

    public function getTenant($id_transaction) {
        try {
            $sql = "SELECT DISTINCT m.id_tenant
                        FROM MENU m
                        JOIN TRANSACTION_DETAIL td ON m.id_menu = td.id_menu
                        WHERE td.id_transaction = :id_transaction";
            
            $this->db->query($sql);
            $this->db->bind(':id_transaction', $id_transaction);
            
            return $this->db->resultSet();
        } catch (Exception $e) {
            throw new Exception("Failed to update expired orders: " . $e->getMessage());
        }
    }
}