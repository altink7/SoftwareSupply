<?php

include_once 'db/Database.php';

class ProductDAO {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function insertProduct($data) {
        $sql = "INSERT INTO product (id, title, description, price, review, fk_customer, image_url) 
                VALUES (:id, :title, :description, :price, :review, :fk_customer, :image_url)";

        try {
            $stmt = $this->db->conn->prepare($sql);
            $stmt->bindParam(':id', $data['id']);
            $stmt->bindParam(':title', $data['title']);
            $stmt->bindParam(':description', $data['description']);
            $stmt->bindParam(':price', $data['price']);
            $stmt->bindParam(':review', $data['review']);
            $stmt->bindParam(':fk_customer', $data['fk_customer']);
            $stmt->bindParam(':image_url', $data['image_url']);
            $stmt->execute();
            return $this->db->conn->lastInsertId();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getProducts() {
        $sql = "SELECT * FROM product";
        try {
            $stmt = $this->db->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getProductsByCategory($category) {
        $sql = "SELECT * FROM product WHERE category = :category";
        try {
            $stmt = $this->db->conn->prepare($sql);
            $stmt->bindParam(':category', $category);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function searchProducts($keyword) {
        $sql = "SELECT * FROM product WHERE title LIKE :title OR description LIKE :description";
        try {
            $stmt = $this->db->conn->prepare($sql);
            $keyword = '%' . $keyword . '%';
            $stmt->bindValue(':title', $keyword);
            $stmt->bindValue(':description', $keyword);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getProductIdByTitle($title){
        $sql = "SELECT id FROM product WHERE title = :title";
        try {
            $stmt = $this->db->conn->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['id'];
        } catch (PDOException $e) {
            return null;
        }
    }
    
}
