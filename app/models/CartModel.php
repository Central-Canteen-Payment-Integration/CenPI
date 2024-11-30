<?php

use Ramsey\Uuid\Uuid;

class CartModel extends Model
{
    public function getCartUser ($id_user) {
        try {
            $sql = "SELECT CART.*, MENU.*, TENANT.tenant_name AS tenant_name
                    FROM CART
                    INNER JOIN MENU ON CART.id_menu = MENU.id_menu
                    INNER JOIN TENANT ON MENU.id_tenant = TENANT.id_tenant
                    WHERE CART.id_user = :id_user";
    
            $this->db->query($sql);
            $this->db->bind(':id_user', $id_user);
    
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Get Cart by User Error: " . $e->getMessage());
            return false;
        }
    }

    public function addCart($id_user, $id_menu)
    {
        try {
            $this->db->beginTransaction();

            $sql = "INSERT INTO CART (id_cart, id_user, id_menu, qty) 
                    VALUES (:id_cart, :id_user, :id_menu, :qty)";
            $id_cart = Uuid::uuid4()->toString();
            $this->db->query($sql);
            $this->db->bind(':id_user', $id_user);
            $this->db->bind(':id_cart', $id_cart);
            $this->db->bind(':id_menu', $id_menu);
            $this->db->bind(':qty', 1);

            $this->db->execute();
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Add to Cart Error: " . $e->getMessage());
            return false;
        }
    }

    public function updateCart($id_cart, $qty)
    {
        try {
            $this->db->beginTransaction();

            if ($qty <= 0) {
                $this->deleteCart($id_cart);
            } else {
                $sql = "UPDATE CART SET qty = :qty WHERE id_cart = :id_cart";
                $this->db->query($sql);
                $this->db->bind(':qty', $qty);
                $this->db->bind(':id_cart', $id_cart);
            }

            $this->db->execute();
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Update Cart Error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteCart($id_cart)
    {
        try {
            $sql = "DELETE FROM CART WHERE id_cart = :id_cart";
            $this->db->query($sql);
            $this->db->bind(':id_cart', $id_cart);

            $this->db->execute();
            return true;
        } catch (Exception $e) {
            error_log("Delete Cart Error: " . $e->getMessage());
            return false;
        }
    }

    public function clearCart($id_user)
    {
        try {
            $sql = "DELETE FROM CART WHERE id_user = :id_user";
            $this->db->query($sql);
            $this->db->bind(':id_user', $id_user);

            $this->db->execute();
            return true;
        } catch (Exception $e) {
            error_log("Clear Cart Error: " . $e->getMessage());
            return false;
        }
    }
}
