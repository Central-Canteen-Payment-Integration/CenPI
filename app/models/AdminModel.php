<?php

use Ramsey\Uuid\Uuid;

class AdminModel extends Model
{
    public function login($username, $password)
    {
        $this->db->query('SELECT * FROM ADMIN WHERE USERNAME = :username');
        $this->db->bind(':username', $username);

        $result = $this->db->single();

        if ($result && password_verify($password, $result['PASSWORD'])) {
            return $result;
        } else {
            return false;
        }
    }

    public function getAllTenants($search = '')
    {
        $sql = "SELECT ID_TENANT, TENANT_NAME, LOCATION_NAME, LOCATION_BOOTH, ACTIVE 
            FROM TENANT 
            WHERE DELETED_AT IS NULL";

        if (!empty($search)) {
            $sql .= " AND (TENANT_NAME LIKE :search OR LOCATION_NAME LIKE :search OR LOCATION_BOOTH LIKE :search)";
        }

        $this->db->query($sql);

        if (!empty($search)) {
            $this->db->bind(':search', '%' . $search . '%');
        }

        return $this->db->resultSet();
    }



    public function updateTenantStatus($tenantId, $status)
    {
        if (!in_array($status, [0, 1])) {
            throw new Exception("Invalid status value");
        }

        $this->db->beginTransaction();

        try {
            $sql = "UPDATE TENANT SET ACTIVE = :status WHERE ID_TENANT = :tenantId AND DELETED_AT IS NULL";
            $this->db->query($sql);
            $this->db->bind(':status', $status);
            $this->db->bind(':tenantId', $tenantId);
            $this->db->execute();

            $adminId = $_SESSION['admin']['id'];
            error_log("Admin ID: $adminId, Tenant ID: $tenantId, Status: $status");

            $logSql = "BEGIN tenant_status_change_log(:adminId, :tenantId, :status); END;";
            $this->db->query($logSql);
            $this->db->bind(':adminId', $adminId);
            $this->db->bind(':tenantId', $tenantId);
            $this->db->bind(':status', $status);
            $this->db->execute();


            $this->db->commit();

            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('Transaction error: ' . $e->getMessage());
            throw $e;
        }
    }


    public function getTenantById($tenantId)
    {
        $sql = "SELECT ID_TENANT, TENANT_NAME, LOCATION_NAME, LOCATION_BOOTH, ACTIVE 
            FROM TENANT 
            WHERE ID_TENANT = :tenantId AND DELETED_AT IS NULL";

        $this->db->query($sql);
        $this->db->bind(':tenantId', $tenantId);
        return $this->db->single();
    }

    public function getAllTransactions()
    {
        $sql = "SELECT t.ID_TRANSACTION, t.TRX_PRICE, t.TRX_STATUS, t.ID_USER, u.USERNAME
                FROM TRANSACTION t
                JOIN USERS u ON t.ID_USER = u.ID_USER
                WHERE t.TRX_STATUS = 'Unpaid' AND t.TRX_METHOD = 'cash'";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function updateTransactionStatus($transactionId) {
        $this->db->beginTransaction();

        try {
            $sql = "UPDATE TRANSACTION
                SET TRX_STATUS = 'Pending'
                WHERE ID_TRANSACTION = :transactionId";

            $this->db->query($sql);
            $this->db->bind(':transactionId', $transactionId);
            $this->db->execute();

            $adminId = $_SESSION['admin']['id'];

            $logSql = "BEGIN update_transaction_status(:transactionId, :adminId); END;";
            $this->db->query($logSql);
            $this->db->bind(':transactionId', $transactionId);
            $this->db->bind(':adminId', $adminId);
            $this->db->execute();

            $this->db->commit();

            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}