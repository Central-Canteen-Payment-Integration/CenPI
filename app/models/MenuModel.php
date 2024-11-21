<?php

class MenuModel extends Model {
    public function getAllMenus() {
        $query = "SELECT * FROM MENU";
        $this->db->query($query);
        return $this->db->resultSet();
    }
}