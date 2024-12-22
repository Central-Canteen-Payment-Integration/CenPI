<?php
use Ramsey\Uuid\Uuid;

class MenuModel extends Model
{
    public function getAllMenus() {
        $query = "SELECT 
                t.tenant_name, 
                t.active AS tenant_active, 
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
                c.category_name AS subcategory_name
            FROM 
                TENANT t
            JOIN 
                MENU m ON t.id_tenant = m.id_tenant
            LEFT JOIN
                MENU_CATEGORY mc ON m.id_menu = mc.id_menu
            LEFT JOIN
                CATEGORY c ON mc.id_category = c.id_category
                WHERE m.active = 1 AND m.deleted_at IS NULL";

        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function addMenu($id_tenant, $name, $price, $pkg_price, $image_path, $menu_type, $id_category) {
        try {
            $this->db->beginTransaction();

            $sql = "INSERT INTO MENU (id_menu, id_tenant, name, price, pkg_price, image_path, menu_type, active)
                    VALUES (:id_menu, :id_tenant, :name, :price, :pkg_price, :image_path, :menu_type, 1)";

            $id_menu = Uuid::uuid7()->toString();

            $this->db->query($sql);
            $this->db->bind(':id_menu', $id_menu);
            $this->db->bind(':id_tenant', $id_tenant);
            $this->db->bind(':name', $name);
            $this->db->bind(':price', $price);
            $this->db->bind(':pkg_price', $pkg_price);
            $this->db->bind(':image_path', $image_path);
            $this->db->bind(':menu_type', $menu_type);

            $this->db->execute();

            $sql = "INSERT INTO MENU_CATEGORY (id_menu, id_category)
                    VALUES (:id_menu, :id_category)";
            $this->db->query($sql);

            $this->db->bind(':id_menu', $id_menu);
            $this->db->bind(':id_category', $id_category);

            $this->db->execute();
            $this->db->commit();

            return ['status' => 'success', 'id_menu' => $id_menu];
        } catch (Exception $e) {
            $this->db->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function updateMenu($id_menu, $name, $price, $pkg_price, $image_path, $menu_type, $id_category) {
        try {
            $this->db->beginTransaction();
    
            // Update menu details
            $sql = "UPDATE MENU SET name = :name, price = :price, pkg_price = :pkg_price, menu_type = :menu_type
                    WHERE id_menu = :id_menu";
            
            $this->db->query($sql);
            $this->db->bind(':id_menu', $id_menu);
            $this->db->bind(':name', $name);
            $this->db->bind(':price', $price);
            $this->db->bind(':pkg_price', $pkg_price);
            $this->db->bind(':menu_type', $menu_type);
    
            $this->db->execute();
    
            // Update image_path only if it is not null
            if ($image_path !== null) {
                $sql = "UPDATE MENU SET image_path = :image_path WHERE id_menu = :id_menu";
                $this->db->query($sql);
                $this->db->bind(':id_menu', $id_menu);
                $this->db->bind(':image_path', $image_path);
                $this->db->execute();
            }
    
            // Update menu category
            $sql = "UPDATE MENU_CATEGORY SET id_category = :id_category WHERE id_menu = :id_menu";
            $this->db->query($sql);
            $this->db->bind(':id_menu', $id_menu);
            $this->db->bind(':id_category', $id_category);
    
            $this->db->execute();
            $this->db->commit();
    
            return ['status' => 'success', 'id_menu' => $id_menu];
        } catch (Exception $e) {
            $this->db->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function deleteMenu($id_menu) {
        try {
            $sql = "UPDATE MENU SET deleted_at = SYSDATE WHERE id_menu = :id_menu AND deleted_at IS NULL";
            
            $this->db->query($sql);
            $this->db->bind(':id_menu', $id_menu);
        
            $this->db->execute();
        
            return true;
        } catch (Exception $e) {
            throw new Exception("Failed to delete menu: " . $e->getMessage());
        }
    }

    public function getMenusByTenant($tenant_id) {
        try {
            $query = "SELECT m.ID_MENU, m.NAME, m.MENU_TYPE, m.PRICE, m.PKG_PRICE, m.IMAGE_PATH, m.ACTIVE, c.CATEGORY_NAME
                      FROM MENU m
                      JOIN MENU_CATEGORY mc ON m.ID_MENU = mc.ID_MENU
                      JOIN CATEGORY c ON mc.ID_CATEGORY = c.ID_CATEGORY
                      WHERE m.ID_TENANT = :tenant_id AND m.DELETED_AT IS NULL";

            $this->db->query($query);
            $this->db->bind(':tenant_id', $tenant_id);
            $data = $this->db->resultSet();

            error_log("Data dari Database: " . print_r($data, true));

            return $data;
        } catch (Exception $e) {
            error_log("Database Error: " . $e->getMessage());
            throw $e;
        }
    }
    
    public function updateMenuStatus($menuId, $newStatus) {
        $query = "UPDATE MENU 
                  SET ACTIVE = :new_status 
                  WHERE ID_MENU = :menu_id";
    
        $this->db->query($query);
        $this->db->bind(':new_status', $newStatus);
        $this->db->bind(':menu_id', $menuId);
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}