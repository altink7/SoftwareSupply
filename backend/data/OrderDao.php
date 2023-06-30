<?php

class OrderDAO {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function saveOrder($orderData, $userId){
        $query = "INSERT INTO `order` (user_fk, total) VALUES (:user_fk, :total)";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':user_fk', $userId);
        $stmt->bindParam(':total', $orderData['total']);

        if ($stmt->execute()) {
            $orderId = $this->db->lastInsertId();
            return $orderId;
        } else {
            return false;
        }
    }

    public function saveOrderPosition($orderId, $productId, $quantity){
        try {
            $query = "INSERT INTO order_position (order_fk, product_fk, quantity, price, total_position_price)
                VALUES (:order_fk, :product_fk, :quantity, (SELECT price FROM product WHERE id = :product_fk),
                        (SELECT price FROM product WHERE id = :product_fk) * :quantity)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':order_fk', $orderId);
            $stmt->bindValue(':product_fk', $productId);
            $stmt->bindValue(':quantity', $quantity);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }
}
