<?php
class DataHandler {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function handleData($data) {
        // Process and save the data to the database
        $salutation = $data['salutation'];
        $vorname = $data['vorname'];
        $nachname = $data['nachname'];
        $adresse = $data['adresse'];
        $plz = $data['plz'];
        $ort = $data['ort'];
        $email = $data['email'];
        $username = $data['username'];
        $password = $data['password'];

        // Perform the database query to insert the data
        $query = "INSERT INTO users (salutation, vorname, nachname, adresse, plz, ort, email, username, password) 
                  VALUES ('$salutation', '$vorname', '$nachname', '$adresse', '$plz', '$ort', '$email', '$username', '$password')";

        // Execute the query
        if ($this->db->query($query)) {
            // Data inserted successfully
            return array('status' => 'success', 'message' => 'User registered successfully');
        } else {
            // Error occurred while inserting data
            return array('status' => 'error', 'message' => 'Error registering user');
        }
    }

    public function getData() {
        // Retrieve data from the database
        $query = "SELECT * FROM users";

        // Execute the query
        $result = $this->db->query($query);

        // Check if any rows were returned
        if ($result->num_rows > 0) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return $data;
        } else {
            // No data found
            return array();
        }
    }
}
?>
