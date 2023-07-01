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
    public function getInvoiceData($userId, $orderId) {
        $sql = "SELECT i.id, i.order_fk, i.created_at, p.title, p.price, op.quantity, op.total_position_price,
                        u.address, u.postal_code, u.city, o.total, o.voucher, u.first_name, u.last_name
        FROM invoice i
        INNER JOIN `order` o ON i.order_fk = o.id
        INNER JOIN order_position op ON o.id = op.order_fk
        INNER JOIN product p ON op.product_fk = p.id
        INNER JOIN users u ON i.user_fk = u.id  
        WHERE i.user_fk = :user_id AND i.order_fk = :order_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $formattedResult = array(
            'id' => $result[0]['id'],
            'order_fk' => $result[0]['order_fk'],
            'created_at' => $result[0]['created_at'],
            'address' => $result[0]['address'],
            'postal_code' => $result[0]['postal_code'],
            'city' => $result[0]['city'],
            'total' => $result[0]['total'],
            'voucher' => $result[0]['voucher'],
            'first_name' => $result[0]['first_name'],
            'last_name' => $result[0]['last_name'],
            'items' => array()
        );

        foreach ($result as $item) {
            $formattedResult['items'][] = array(
                'title' => $item['title'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'total_position_price' => $item['total_position_price']
            );
        }

        return $formattedResult;
    }


}
