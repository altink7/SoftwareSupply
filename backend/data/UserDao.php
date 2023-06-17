<?php
include_once 'db/Database.php';


class UserDAO {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function insertUser($data) {
        $sql = "INSERT INTO users (salutation, first_name, last_name, address, postal_code, city, email, username, password, payment) 
                VALUES (:salutation, :first_name, :last_name, :address, :postal_code, :city, :email, :username, :password, :payment)";

        try {
            $stmt = $this->db->conn->prepare($sql);
            $stmt->bindParam(':salutation', $data['salutation']);
            $stmt->bindParam(':first_name', $data['vorname']);
            $stmt->bindParam(':last_name', $data['nachname']);
            $stmt->bindParam(':address', $data['adresse']);
            $stmt->bindParam(':postal_code', $data['plz']);
            $stmt->bindParam(':city', $data['ort']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':username', $data['username']);
            $stmt->bindParam(':payment', $data['payment']);

            $hashedPassword = $this->hashPassword($data['password']);
            $stmt->bindParam(':password', $hashedPassword);

            $stmt->execute();
            return $this->db->conn->lastInsertId();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getUsers() {
        $sql = "SELECT * FROM users";
        try {
            $stmt = $this->db->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getUserByUsernameOrEmail($usernameOrEmail) {
        $sql = "SELECT * FROM users WHERE username = :username OR email = :email";
        try {
            $stmt = $this->db->conn->prepare($sql);
            $stmt->bindParam(':username', $usernameOrEmail);
            $stmt->bindParam(':email', $usernameOrEmail);
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

?>