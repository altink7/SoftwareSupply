<?php

class DataHandler {
    private $db;

    public function __construct() {
        $this->db = new Database();
        $this->db->connect();
    }

    public function getUserData() {
        $data = $this->db->getUsers();
        echo json_encode($data);
    }
}

?>
