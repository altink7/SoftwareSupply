<?php

class Database {
    private static $host = "localhost";
    private static $user = "user";
    private static $password = "password";
    private static $database = "softwaresupplydb";
    private $conn;

    public function __construct() {
        $this->connect();
    }

    public function connect() {
        try {
            $this->conn = new PDO("mysql:host=".self::$host.";dbname=".self::$database, self::$user, self::$password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            error_log("Connection failed: " . $e->getMessage());
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function disconnect() {
        $this->conn = null;
    }

    public function insertUser($data) {
        $sql = "INSERT INTO users (salutation, first_name, last_name, address, postal_code, city, email, username, password) 
                VALUES (:salutation, :first_name, :last_name, :address, :postal_code, :city, :email, :username, :password)";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':salutation', $data['salutation']);
            $stmt->bindParam(':first_name', $data['vorname']);
            $stmt->bindParam(':last_name', $data['nachname']);
            $stmt->bindParam(':address', $data['adresse']);
            $stmt->bindParam(':postal_code', $data['plz']);
            $stmt->bindParam(':city', $data['ort']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':username', $data['username']);

            $hashedPassword = $this->hashPassword($data['password']);
            $stmt->bindParam(':password', $hashedPassword);

            $stmt->execute();
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    public function insertProduct($data) {
        $sql = "INSERT INTO users (id, title, description, price, review, fk_customer) 
                VALUES (:id, :title, :price, :review, :fk_customer)";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $data['id']);
            $stmt->bindParam(':title', $data['title']);
            $stmt->bindParam(':description', $data['description']);
            $stmt->bindParam(':address', $data['adresse']);
            $stmt->bindParam(':price', $data['price']);
            $stmt->bindParam(':review', $data['review']);
            $stmt->bindParam(':fk_customer', $data['fk_customer']);
            $stmt->execute();
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getUsers(){
        $sql = "SELECT * FROM users";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            return null;
        }
   } 

   public function getProducts(){
    $sql = "SELECT * FROM product";
    try {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        return null;
        }
    }

    public function getUserByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = :username";
        try {
          $stmt = $this->conn->prepare($sql);
          $stmt->bindParam(':username', $username);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          return $result;
        } catch (PDOException $e) {
          return null;
        }
      }

    private function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }
}
