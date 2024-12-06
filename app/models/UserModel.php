<?php
use Ramsey\Uuid\Uuid;

class UserModel extends Model {
    public function register($username, $password, $email) {
        try {
            $this->db->beginTransaction();
    
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
            $sql = "INSERT INTO USERS (id_user, username, password, email, token_activation)
                                VALUES (:id_user, :username, :password, :email, :token_activation)";
    
            $id_user = Uuid::uuid7()->toString();
            $token_activation = Uuid::uuid7()->toString();
    
            $this->db->query($sql);
            $this->db->bind(':id_user', $id_user);
            $this->db->bind(':username', $username);
            $this->db->bind(':password', $hashedPassword);
            $this->db->bind(':token_activation', $token_activation);
            $this->db->bind(':email', $email);
    
            $this->db->execute();
            $this->db->commit();
    
            // Send verification email
            $this->sendVerificationEmail($email, $token_activation);
    
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Register Error: " . $e->getMessage());
            return false;
        }
    }

    private function sendVerificationEmail($email, $token) {
        $mailer = new Mailer();
        $subject = 'Account Verification';
        $verificationLink = "http://cenpi.test/User/verify/" . $token;
        $body = "Please click the following link to verify your account: <a href='$verificationLink'>Verify Account</a>";
    
        return $mailer->sendMail($email, $subject, $body);
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

    public function verifyUser ($token) {
        try {
            $sql = "SELECT id_user, active FROM USERS WHERE token_activation = :token";
            $this->db->query($sql);
            $this->db->bind(':token', $token);
    
            $user = $this->db->single();
    
            if ($user) { 
                if ($user['ACTIVE'] == 0) {
                    $sql = "UPDATE USERS SET active = 1 WHERE id_user = :id_user";
                    $this->db->query($sql);
                    $this->db->bind(':id_user', $user['ID_USER']);
                    $this->db->execute();
    
                    return "Account activated successfully.";
                } else if ($user['ACTIVE'] == 1) {
                    return "Account already activated.";
                }
            }
    
            return "Token not valid.";
        } catch (Exception $e) {
            error_log("Verification Error: " . $e->getMessage());
            return "An error occurred during verification.";
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
                            PASSWORD = :PASSWORD 
                        WHERE id_user = :id_user";

                $this->db->query($sql);
                $this->db->bind(':PASSWORD', $hashedNewPassword);
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

    public function findUserByEmail($email) {
        try {
            $sql = "SELECT * FROM USERS WHERE email = :email";
            $this->db->query($sql);
            $this->db->bind(':email', $email);
    
            return $this->db->single();
        } catch (Exception $e) {
            error_log("Find User By Email Error: " . $e->getMessage());
            return false;
        }
    }

    public function verifyPassword($userId, $password) {
        $sql = "SELECT PASSWORD FROM USERS WHERE id_user = :id_user";
        $this->db->query($sql);
        $this->db->bind(':id_user', $userId);

        $storedPassword = $this->db->single();

        if (password_verify($password, $storedPassword['password'])) {
            return true;
        } else {
            return false;
        }
    }
}
