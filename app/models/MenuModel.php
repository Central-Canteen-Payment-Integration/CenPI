<?php

class MenuModel extends Model
{
    public function getMenusByLocation($location)
    {
        $query = "SELECT * FROM MENU WHERE LOCATION = :location";
        $this->db->query($query);
        $this->db->bind(':location', $location);
        return $this->db->resultSet();
    }

    public function getAllMenus()
    {
        $query = "SELECT * FROM MENU";
        $this->db->query($query);
        return $this->db->resultSet();
    }
}
