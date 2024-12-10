<?php

class MenuModel extends Model
{
    public function getAllMenus()
    {
        $query = "SELECT 
                t.tenant_name, 
                t.active AS tenant_active, 
                t.image_path AS tenant_image_path, 
                t.location_name, 
                t.location_booth, 
                m.id_menu, 
                m.id_tenant,
                m.name, 
                m.price, 
                m.pkg_price, 
                m.menu_type AS main_category,
                m.image_path AS menu_image_path,
                m.active AS menu_active,
                c.category_name AS subcategory_name,
            FROM 
                TENANT t
            JOIN 
                MENU m ON t.id_tenant = m.id_tenant
            LEFT JOIN
                MENU_CATEGORY mc ON m.id_menu = mc.id_menu
            LEFT JOIN
                CATEGORY c ON mc.id_category = c.id_category";

        $this->db->query($query);
        return $this->db->resultSet();
    }
}
