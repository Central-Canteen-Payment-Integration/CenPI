<?php
use Ramsey\Uuid\Uuid;

class UserModel extends Model {
    public function register($username, $password, $email) {
        try {
            $this->db->beginTransaction();

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $sql = "INSERT INTO USERS (id_user, username, password, email, active)
                                VALUES (:id_user, :username, :password, :email, 0)";

            $id_user = Uuid::uuid4()->toString();

            $this->db->query($sql);
            $this->db->bind(':id_user', $id_user);
            $this->db->bind(':username', $username);
            $this->db->bind(':password', $hashedPassword);
            $this->db->bind(':email', $email);

            $this->db->execute();
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Register Error: " . $e->getMessage());
            return false;
        }
    }

    public function login($username, $password) {
        try {
            $sql = "SELECT * FROM USERS WHERE username = :username";
            $this->db->query($sql);
            $this->db->bind(':username', $username);

            $user = $this->db->single();

            if ($user && password_verify($password, $user['PASSWORD'])) {
                return $user;
            }

            return false;
        } catch (Exception $e) {
            error_log("Login Error: " . $e->getMessage());
            return false;
        }
    }

    public function getUserById($userId) {
        $sql = "SELECT * FROM USERS WHERE id_user = :id_user";
        $this->db->query($sql);
        $this->db->bind(':id_user', $userId);

        return $this->db->single();
    }

    public function updateUserProfile($userId, $username, $birthdate, $phone_number, $hashedNewPassword = null) {
        $this->db->beginTransaction();

        try {
            if ($hashedNewPassword !== null) {
                $sql = "UPDATE USERS 
                        SET username = :username, 
                            birthdate = TO_DATE(:birthdate, 'YYYY-MM-DD'), 
                            phone_number = :phone_number, 
                            pass_user = :pass_user 
                        WHERE id_user = :id_user";

                $this->db->query($sql);
                $this->db->bind(':pass_user', $hashedNewPassword);
            } else {
                $sql = "UPDATE USERS 
                        SET username = :username, 
                            birthdate = TO_DATE(:birthdate, 'YYYY-MM-DD'), 
                            phone_number = :phone_number, 
                        WHERE id_user = :id_user";
                $this->db->query($sql);
            }

            $this->db->bind(':username', $username);
            $this->db->bind(':birthdate', $birthdate);
            $this->db->bind(':phone_number', $phone_number);
            $this->db->bind(':id_user', $userId);

            $this->db->execute();
            $this->db->commit();

            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function verifyPassword($userId, $password) {
        $sql = "SELECT PASS_USER FROM USERS WHERE id_user = :id_user";
        $this->db->query($sql);
        $this->db->bind(':id_user', $userId);

        $storedPassword = $this->db->single();

        if (password_verify($password, $storedPassword['PASS_USER'])) {
            return true;
        } else {
            return false;
        }
    }
}
