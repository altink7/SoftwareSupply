<?php

class OrderPosition {
    private $positionId;
    private $orderId;
    private $productId;
    private $price;
    private $quantity;
    private $totalPositionPrice;

    // Getters and Setters
    public function getPositionId() {
    return $this->positionId;
    }

    public function setPositionId($positionId) {
    $this->positionId = $positionId;
    }

    public function getOrderId() {
    return $this->orderId;
    }

    public function setOrderId($orderId) {
    $this->orderId = $orderId;
    }

    public function getProductId() {
    return $this->productId;
    }

    public function setProductId($productId) {
    $this->productId = $productId;
    }

    public function getPrice() {
    return $this->price;
    }

    public function setPrice($price) {
    $this->price = $price;
    }

    public function getQuantity() {
    return $this->quantity;
    }

    public function setQuantity($quantity) {
    $this->quantity = $quantity;
    }

    public function getTotalPositionPrice() {
    return $this->totalPositionPrice;
    }

    public function setTotalPositionPrice($totalPositionPrice) {
    $this->totalPositionPrice = $totalPositionPrice;
    }
}