<?php

class CategoryModel extends Model
{
    public function getCategory() {
        $sql = "SELECT * FROM CATEGORY";
        $this->db->query($sql);
        return $this->db->resultSet();
    }
}