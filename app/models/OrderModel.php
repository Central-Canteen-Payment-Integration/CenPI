<?php

class OrderModel extends Model
{
    public function getActiveOrdersByUser($userId)
    {
        $sql = "SELECT * FROM TRANSACTION WHERE id_user = :user_id AND trx_status IN ('onPayment', 'onPending')";
        $this->db->query($sql);
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    public function getHistoryOrdersByUser($userId)
    {
        $sql = "SELECT * FROM TRANSACTION WHERE id_user = :user_id AND trx_status IN ('Expired', 'Completed')";
        $this->db->query($sql);
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    public function getOrderDetails($transactionId)
    {
        $sql = "SELECT 
                    td.*, 
                    m.name AS menu_name, 
                    t.tenant_name
                FROM TRANSACTION_DETAIL td
                JOIN MENU m ON td.id_menu = m.id_menu
                JOIN TENANT t ON m.id_tenant = t.id_tenant
                WHERE td.id_transaction = :transaction_id";

        $this->db->query($sql);
        $this->db->bind(':transaction_id', $transactionId);
        return $this->db->resultSet();
    }


}
