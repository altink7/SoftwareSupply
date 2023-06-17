<?php
class Database {
    public static $host = "localhost";
    public static $user = "user";
    public static $password = "password";
    public static $database = "softwaresupplydb";
    private $dbConfig;
    public $conn;

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
}
?>
