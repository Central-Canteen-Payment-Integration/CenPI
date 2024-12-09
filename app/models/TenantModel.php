<?php
use Ramsey\Uuid\Uuid;

class TenantModel extends Model {
    public function register($tenant_name, $username, $password, $email, $location_name, $location_booth) {
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
            var_dump("Register Error: " . $e->getMessage());
            return false;
        }
    }

    public function login($username, $password) {
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

    public function findUserByUsernameOrEmail($username, $email) {
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
}
