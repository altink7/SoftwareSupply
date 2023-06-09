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

    public function getUserProfile($usernameOrEmail) {
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

    //find id by username
    public function getUserIdByUsername($usernameOrEmail) {
        if (empty($usernameOrEmail)) return 3;

        $sql = "SELECT id FROM users WHERE username = :username OR email = :email";
        try {
            $stmt = $this->db->conn->prepare($sql);
            $stmt->bindParam(':username', $usernameOrEmail);
            $stmt->bindParam(':email', $usernameOrEmail);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['id'];
        } catch (PDOException $e) {
            return 3;
        }
    }

    public function updateUserProfile($usernameOrEmail, $updatedData) {
        $sql = "UPDATE users 
                SET first_name = :first_name, last_name = :last_name, email = :email, 
                    address = :address, postal_code = :postal_code, city = :city";
    
        // Check if the password is modified
        if (!empty($updatedData['password'])) {
            $sql .= ", password = :password";
            $hashedPassword = $this->hashPassword($updatedData['password']);
        }
    
        $sql .= ", payment = :payment 
                  WHERE username = :username";
    
        try {
            $stmt = $this->db->conn->prepare($sql);
            $stmt->bindParam(':first_name', $updatedData['first_name']);
            $stmt->bindParam(':last_name', $updatedData['last_name']);
            $stmt->bindParam(':email', $updatedData['email']);
            $stmt->bindParam(':address', $updatedData['address']);
            $stmt->bindParam(':postal_code', $updatedData['postal_code']);
            $stmt->bindParam(':city', $updatedData['city']);
    
            // Bind hashed password if modified
            if (!empty($hashedPassword)) {
                $stmt->bindParam(':password', $hashedPassword);
            }
    
            $stmt->bindParam(':payment', $updatedData['payment']);
            $stmt->bindParam(':username', $usernameOrEmail);
            $stmt->bindParam(':email', $usernameOrEmail);
    
            $result = $stmt->execute();
    
            if ($result) {
                return true;
            } else {
                $errorInfo = $stmt->errorInfo();
                error_log("Error updating user profile: " . $errorInfo[2]);
                return false;
            }
        } catch (PDOException $e) {
            error_log("PDOException in updateUserProfile: " . $e->getMessage());
            return false;
        }
    }
    

    private function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }

}
