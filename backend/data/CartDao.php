<?php

include_once 'db/Database.php';

class CartDAO {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function addToCart($productId) {
        $userId = 1; // Replace wenn user drinnen ist

        try {
            $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, 1)";
            $stmt = $this->db->conn->prepare($sql);
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getCartCount() {
        $userId = 1; // Replace wenn user drinnen ist

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
}
?>
