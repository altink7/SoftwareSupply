<?php
class DataHandler {
    private $db;

    public function __construct() {
        Database::connect();
        $this->db = Database::$db;
    }

  public function handleData($data) {
    $salutation = $this->db->real_escape_string($data['salutation']);
    $vorname = $this->db->real_escape_string($data['vorname']);
    $nachname = $this->db->real_escape_string($data['nachname']);
    $adresse = $this->db->real_escape_string($data['adresse']);
    $plz = $this->db->real_escape_string($data['plz']);
    $ort = $this->db->real_escape_string($data['ort']);
    $email = $this->db->real_escape_string($data['email']);
    $username = $this->db->real_escape_string($data['username']);
    $password = $this->db->real_escape_string($data['password']);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    //Sample data INSERT
    //INSERT INTO users (salutation, vorname, nachname, adresse, plz, ort, email, username, password)
    //VALUES ('mr', 'John', 'Doe', '123 Main St', '1234', 'Anytown', 'johndoe@example.com', 'johndoe', 'password1'),

    $sql = "INSERT INTO users (salutation, vorname, nachname, adresse, plz, ort, email, username, password)
     VALUES ('$salutation', '$vorname', '$nachname', '$adresse', '$plz', '$ort', '$email', '$username', '$hashed_password')";
    if ($this->db->query($sql) === TRUE) {
      return "User registered successfully!";
    } else {

      return "Error: " . $sql . "<br>" . $this->db->error;
    }
  }
  public function __destruct() {
    $this->db->close();
  }
}
