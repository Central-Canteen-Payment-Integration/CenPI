<?php

class UserModel extends Model {
    public function register($username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        
        $this->db->query($sql);
        $this->db->bind(':username', $username);
        $this->db->bind(':password', $hashedPassword);
        
        return $this->db->execute();
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
