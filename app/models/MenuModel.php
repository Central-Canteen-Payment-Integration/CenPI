<?php

class MenuModel extends Model
{
    public function getAllMenus() {
        $query = "SELECT 
                    t.tenant_name, 
                    t.active AS tenant_active, 
                    t.image_path AS tenant_image_path, 
                    t.location_name AS, 
                    t.location_booth AS, 
                    m.id_menu AS, 
                    m.id_tenant AS,
                    m.name AS, 
                    m.price AS, 
                    m.pkg_price AS, 
                    m.image_path AS menu_image_path,
                    m.active AS menu_active
                FROM 
                    TENANT t
                JOIN 
                    MENU m ON t.id_tenant = m.id_tenant";
        $this->db->query($query);
        return $this->db->resultSet();
    }
}
