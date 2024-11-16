<?php

class UserModel extends Model {
    public function register($username, $password, $email) {
        $this->db->beginTransaction();
        
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $aktivasi = 1; 
        
        $sql = "INSERT INTO USERS (username, pass_user, email, aktivasi) 
                VALUES (:username, :password, :email, :aktivasi)";
        
        $this->db->query($sql);
        $this->db->bind(':username', $username);
        $this->db->bind(':password', $hashedPassword);
        $this->db->bind(':email', $email);
        $this->db->bind(':aktivasi', $aktivasi);
        
        if ($this->db->execute()) {
            $this->db->commit();
            return true;
        } 
        
        $this->db->rollBack();
        return false; 
    }
    
    
    public function login($username, $password) {
        $sql = "SELECT * FROM USERS WHERE USERNAME = :username";
        $this->db->query($sql);
        $this->db->bind(':username', $username);
        
        $user = $this->db->single();
        
        if ($user && password_verify($password, $user['PASS_USER'])) {
            return $user;
        }
        
        return false;
    }
}
