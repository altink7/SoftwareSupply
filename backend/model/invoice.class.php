<?php

class Invoice {
    private $id;
    private $user_fk;
    private $order_id;
    private $created_at;

    public function __construct($user_fk, $order_id) {
        $this->user_fk = $user_fk;
        $this->order_id = $order_id;
        $this->created_at = date('Y-m-d H:i:s');
    }

    public function getId() {
        return $this->id;
    }

    public function getUserFk() {
        return $this->user_fk;
    }

    public function setUserFk($user_fk) {
        $this->user_fk = $user_fk;
    }

    public function getOrderId() {
        return $this->order_id;
    }

    public function setOrderId($order_id) {
        $this->order_id = $order_id;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

}
