<?php

class OrderDAO {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function saveOrder($totalPrice, $userId){
        $query = "INSERT INTO `order` (user_fk, total) VALUES (:user_fk, :total)";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':user_fk', $userId);
        $stmt->bindParam(':total', $totalPrice);

        if ($stmt->execute()) {
            $orderId = $this->db->lastInsertId();
            return $orderId;
        } else {
            return false;
        }
    }

    public function saveOrderPosition($orderId, $productId, $quantity) {
        $query = "INSERT INTO order_position (order_fk, product_fk, quantity, price, total_position_price)
        VALUES (:order_fk, :product_fk, :quantity, :price, :total_position_price)";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':order_fk', $orderId);
        $stmt->bindParam(':product_fk', $productId);
        $stmt->bindParam(':quantity', $quantity);

        $price = $this->getProductPrice($productId);
        $stmt->bindParam(':price', $price);

        $totalPositionPrice = $this->calculateTotalPositionPrice($productId, $quantity);
        $stmt->bindParam(':total_position_price', $totalPositionPrice);

        $stmt->execute();
        return true;
    }


    public function getProductPrice($productId) {
        $query = "SELECT price FROM product WHERE id = :product_fk";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':product_fk', $productId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['price'];
    }

    public function calculateTotalPositionPrice($productId, $quantity) {
        $productPrice = $this->getProductPrice($productId);
        return $productPrice * $quantity;
    }

    public function getOrdersForUser($userId){
        $query = "SELECT * FROM `order` WHERE user_fk = :user_fk";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_fk', $userId);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}
