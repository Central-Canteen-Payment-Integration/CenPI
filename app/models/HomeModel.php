<?php

class HomeModel extends Model{
    public function validateLogin($username, $password) {
        $query = "SELECT * FROM users WHERE username = :username";
        $this->db->query($query);
        $this->db->bind(":username", $username);
        
        $user = $this->db->single();

        if ($user && $user['password'] === $password) {
            return $user; 
        }
        return false;
    }
}