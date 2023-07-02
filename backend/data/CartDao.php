<?php

include_once 'db/Database.php';

class CartDAO {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function addToCart($productId, $userId) {
        try {
           // Check if the product is already in the cart for the user
            $sql = "SELECT quantity FROM cart WHERE user_id = :user_id AND product_id = :product_id";
            $stmt = $this->db->conn->prepare($sql);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
            $existingQuantity = $stmt->fetchColumn();

            if (!$existingQuantity) {
                // Product does not exist in the cart, insert a new row
                $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, 1)";
            }

            $stmt = $this->db->conn->prepare($sql);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();

        
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getCartCount($userId) {
        try {
            $sql = "SELECT COUNT(*) FROM cart WHERE user_id = :user_id";
            $stmt = $this->db->conn->prepare($sql);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            $stmt->closeCursor();

            return $count;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getCartData($userId) {
        try {
            $sql = "SELECT p.title, p.price, p.id, c.quantity FROM cart c
                    INNER JOIN product p ON c.product_id = p.id
                    WHERE c.user_id = :user_id";
            $stmt = $this->db->conn->prepare($sql);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $cartData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
    
            return $cartData;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function removeProduct($userId, $productId) {
        $sql = "DELETE FROM cart WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
        return true;
    }
    
    public function calculateTotal($userId) {
        $sql = "SELECT SUM(price * quantity) AS total FROM cart INNER JOIN products ON cart.product_id = products.id WHERE cart.user_id = :user_id";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $total = $stmt->fetchColumn();
        $stmt->closeCursor();
    
        return $total;
    }

    public function updateQuantity($username, $productId, $quantity) {
        $query = "UPDATE cart SET quantity = :quantity WHERE user_id = :username AND product_id = :product_id";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':product_id', $productId);
        return $stmt->execute();
    }

    public function deleteCartData($userId) {
        $sql = "DELETE FROM cart WHERE user_id = :user_id";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
        return true;
    }


}
