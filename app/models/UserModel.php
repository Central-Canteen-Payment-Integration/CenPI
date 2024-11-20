<?php

class UserModel extends Model {
    public function register($username, $password, $email) {
        try {
            $this->db->beginTransaction();
            
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            
            $sql = "INSERT INTO USERS (username, pass_user, email) 
                    VALUES (:username, :password, :email)";
            
            $this->db->query($sql);
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
            $sql = "SELECT * FROM USERS WHERE USERNAME = :username";
            $this->db->query($sql);
            $this->db->bind(':username', $username);
            
            $user = $this->db->single();
            
            if ($user && password_verify($password, $user['PASS_USER'])) {
                return $user;
            }
            
            return false;
        } catch (Exception $e) {
            error_log("Login Error: " . $e->getMessage());
            return false;
        }
    }
}
