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
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function disconnect() {
        $this->conn = null;
    }

    public function insertCustomer($data) {
        $sql = "INSERT INTO customers (salutation, vorname, nachname, adresse, plz, ort, email, username, password) 
                VALUES (:salutation, :vorname, :nachname, :adresse, :plz, :ort, :email, :username, :password)";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':salutation', $data['salutation']);
            $stmt->bindParam(':vorname', $data['vorname']);
            $stmt->bindParam(':nachname', $data['nachname']);
            $stmt->bindParam(':adresse', $data['adresse']);
            $stmt->bindParam(':plz', $data['plz']);
            $stmt->bindParam(':ort', $data['ort']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':username', $data['username']);
            $stmt->bindParam(':password', $data['password']);
            $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}

?>
