<?php

class InvoiceDao {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }
    public function saveInvoice($userId, $orderId){
        $sql = "INSERT INTO invoice (user_fk, order_fk) VALUES (:user_fk, :order_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_fk', $userId);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();
        return true;
    }

    // mit inner joins holen wir uns alle relevanten daten aus den tabellen invoice, order, order_position, product und user
    public function getInvoiceData($userId, $orderId){
        $sql = "SELECT i.id, i.created_at, p.title, p.price, op.quantity, op.total_position_price, u.address, o.total, o.id FROM invoice i
                INNER JOIN `order` o ON i.order_fk = o.id
                INNER JOIN order_position op ON o.id = op.order_fk
                INNER JOIN product p ON op.product_fk = p.id
                INNER JOIN user u ON i.user_fk = u.id  
                WHERE i.user_fk = :user_id AND i.order_fk = :order_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
