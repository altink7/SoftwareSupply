<?php

class DataHandler {
    private $db;

    public function __construct() {
        Database::connect();
        $this->db = Database::$db;
    }

    public function getUserData() {
        $result = $this->db->query("SELECT * FROM users;");
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    }
}
