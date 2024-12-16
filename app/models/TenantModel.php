<?php
use Ramsey\Uuid\Uuid;

class TenantModel extends Model
{
    public function register($tenant_name, $username, $password, $email, $location_name, $location_booth)
    {
        try {
            $this->db->beginTransaction();

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $sql = "INSERT INTO TENANT (id_tenant, tenant_name, username, password, email, location_name, location_booth)
                                VALUES (:id_tenant, :tenant_name, :username, :password, :email, :location_name, :location_booth)";

            $id_tenant = Uuid::uuid7()->toString();

            $this->db->query($sql);
            $this->db->bind(':id_tenant', $id_tenant);
            $this->db->bind(':tenant_name', $tenant_name);
            $this->db->bind(':username', $username);
            $this->db->bind(':password', $hashedPassword);
            $this->db->bind(':email', $email);
            $this->db->bind(':location_name', $location_name);
            $this->db->bind(':location_booth', $location_booth);

            $this->db->execute();
            $this->db->commit();

            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function login($username, $password)
    {
        try {
            $sql = "SELECT * FROM TENANT WHERE username = :username";
            $this->db->query($sql);
            $this->db->bind(':username', $username);

            $tenant = $this->db->single();

            if ($tenant && password_verify($password, $tenant['PASSWORD'])) {
                return $tenant;
            }

            return false;
        } catch (Exception $e) {
            error_log("Login Error: " . $e->getMessage());
            return false;
        }
    }
    public function getTenantById($tenantId)
    {
        $sql = "SELECT * FROM TENANT WHERE id_tenant = :id_tenant";
        $this->db->query($sql);
        $this->db->bind(':id_tenant', $tenantId);

        return $this->db->single();
    }

    public function updateTenantProfile($tenantId, $tenantName, $hashedPassword = null)
    {
        try {
            $this->db->beginTransaction();

            $sql = "UPDATE TENANT SET tenant_name = :tenant_name";

            if ($hashedPassword) {
                $sql .= ", password = :password";
            }

            $sql .= " WHERE id_tenant = :id_tenant";

            $this->db->query($sql);
            $this->db->bind(':tenant_name', $tenantName);
            $this->db->bind(':id_tenant', $tenantId);

            if ($hashedPassword) {
                $this->db->bind(':password', $hashedPassword);
            }

            $this->db->execute();
            $this->db->commit();

            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Update Tenant Profile Error: " . $e->getMessage());
            return false;
        }
    }

    public function verifyPassword($tenantId, $password)
    {
        $sql = "SELECT password FROM TENANT WHERE id_tenant = :id_tenant";
        $this->db->query($sql);
        $this->db->bind(':id_tenant', $tenantId);

        $result = $this->db->single();

        return password_verify($password, $result['password']);
    }

    public function findUserByUsernameOrEmail($username, $email)
    {
        try {
            $sql = "SELECT * FROM TENANT WHERE username = :username OR email = :email";
            $this->db->query($sql);

            $this->db->bind(':username', $username);
            $this->db->bind(':email', $email);

            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Find Tenant By Username or Email Error: " . $e->getMessage());
            return false;
        }
    }

    public function getDashboardData($tenantId, $startDate, $endDate) {
        if (strtotime($startDate) === false || strtotime($endDate) === false) {
            error_log("Invalid date format for startDate or endDate");
            return false;
        }
    
        $startDate = date('d-m-Y 00:00:00', strtotime($startDate));
        $endDate = date('d-m-Y 23:59:59', strtotime($endDate));
    
        $sql = "
            SELECT NVL(COUNT(td.id_transaction), 0) AS TOTAL_ORDERS, 
                   NVL(SUM(td.qty_price + td.pkg_price), 0) AS TOTAL_REVENUE
            FROM TRANSACTION t
            JOIN TRANSACTION_DETAIL td ON t.id_transaction = td.id_transaction
            JOIN MENU m ON td.id_menu = m.id_menu
            WHERE m.id_tenant = :tenantId
              AND t.trx_date BETWEEN TO_DATE(:startDate, 'DD-MM-YYYY HH24:MI:SS') AND TO_DATE(:endDate, 'DD-MM-YYYY HH24:MI:SS')
              AND t.trx_status = 'Completed'
        ";
    
        $this->db->query($sql);
        $this->db->bind(':tenantId', $tenantId);
        $this->db->bind(':startDate', $startDate);
        $this->db->bind(':endDate', $endDate);
        $result = $this->db->single();
        $totalOrders = isset($result['TOTAL_ORDERS']) ? (int)$result['TOTAL_ORDERS'] : 0;
        $totalRevenue = isset($result['TOTAL_REVENUE']) ? (int)$result['TOTAL_REVENUE'] : 0;
    
        $sql = "
            SELECT TO_CHAR(t.trx_date, 'DD-MM-YYYY') AS trx_date,
                   NVL(SUM(td.qty_price + td.pkg_price), 0) AS total_revenue
            FROM TRANSACTION t
            JOIN TRANSACTION_DETAIL td ON t.id_transaction = td.id_transaction
            JOIN MENU m ON td.id_menu = m.id_menu
            WHERE m.id_tenant = :tenantId
              AND t.trx_date BETWEEN TO_DATE(:startDate, 'DD-MM-YYYY HH24:MI:SS') AND TO_DATE(:endDate, 'DD-MM-YYYY HH24:MI:SS')
              AND t.trx_status = 'Completed'
            GROUP BY TO_CHAR(t.trx_date, 'DD-MM-YYYY')
            ORDER BY trx_date
        ";
    
        $this->db->query($sql);
        $this->db->bind(':tenantId', $tenantId);
        $this->db->bind(':startDate', $startDate);
        $this->db->bind(':endDate', $endDate);
        $revenuePerDayResults = $this->db->resultSet();
    
        $chartLabels = [];
        $chartData = [];
    
        if (!empty($revenuePerDayResults)) {
            foreach ($revenuePerDayResults as $result) {
                $chartLabels[] = $result['TRX_DATE'];
                $chartData[] = (float)$result['TOTAL_REVENUE'];
            }
        }
    
        return [
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];
    }

    public function addMenu($id_tenant, $name, $price, $pkg_price, $image_path, $menu_type, $id_category)
    {
        try {
            $this->db->beginTransaction();

            $sql = "INSERT INTO MENU (id_menu, id_tenant, name, price, pkg_price, image_path, menu_type, active)
                    VALUES (:id_menu, :id_tenant, :name, :price, :pkg_price, :image_path, :menu_type, 1)";

            $id_menu = Uuid::uuid7()->toString();

            $this->db->query($sql);
            $this->db->bind(':id_menu', $id_menu);
            $this->db->bind(':id_tenant', $id_tenant);
            $this->db->bind(':name', $name);
            $this->db->bind(':price', $price);
            $this->db->bind(':pkg_price', $pkg_price);
            $this->db->bind(':image_path', $image_path);
            $this->db->bind(':menu_type', $menu_type);

            $this->db->execute();

            $sql = "INSERT INTO MENU_CATEGORY (id_menu, id_category)
                    VALUES (:id_menu, :id_category)";
            $this->db->query($sql);

            $this->db->bind(':id_menu', $id_menu);
            $this->db->bind(':id_category', $id_category);

            $this->db->execute();
            $this->db->commit();

            return ['status' => 'success', 'id_menu' => $id_menu];
        } catch (Exception $e) {
            $this->db->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getMenusByTenant($tenant_id)
    {
        try {
            $query = "SELECT m.ID_MENU, m.NAME, m.MENU_TYPE, m.PRICE, m.PKG_PRICE, m.IMAGE_PATH, m.ACTIVE, c.CATEGORY_NAME
                      FROM MENU m
                      JOIN MENU_CATEGORY mc ON m.ID_MENU = mc.ID_MENU
                      JOIN CATEGORY c ON mc.ID_CATEGORY = c.ID_CATEGORY
                      WHERE m.ID_TENANT = :tenant_id";

            $this->db->query($query);
            $this->db->bind(':tenant_id', $tenant_id);
            $data = $this->db->resultSet();

            error_log("Data dari Database: " . print_r($data, true));

            return $data;
        } catch (Exception $e) {
            error_log("Database Error: " . $e->getMessage());
            throw $e;
        }
    }
}