<?php

class OrderDAO {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function saveOrder($orderData, $userId){
        // Prepare the query
        $query = "INSERT INTO `order` (user_fk, total) VALUES (:user_fk, :total)";
        $stmt = $this->db->prepare($query);

        // Bind parameters
        $stmt->bindParam(':user_fk', $userId);
        $stmt->bindParam(':total', $orderData['total']);

        // Execute the query
        if ($stmt->execute()) {
            // Return the ID of the saved order
            $orderId = $this->db->lastInsertId();
            return $orderId;
        } else {
            return false;
        }
    }

    //fuer positionen muss auch erstellt werden, wird gemacht dann
}
