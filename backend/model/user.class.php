<?php

class User {
    private $salutation;
    private $vorname;
    private $nachname;
    private $adresse;
    private $plz;
    private $ort;
    private $email;
    private $username;
    private $password;

    public function __construct($salutation, $vorname, $nachname, $adresse, $plz, $ort, $email, $username, $password) {
        $this->salutation = $salutation;
        $this->vorname = $vorname;
        $this->nachname = $nachname;
        $this->adresse = $adresse;
        $this->plz = $plz;
        $this->ort = $ort;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
    }

    // getters and setters for all properties
    public function getSalutation() {
        return $this->salutation;
    }

    public function setSalutation($salutation) {
        $this->salutation = $salutation;
    }

    public function getVorname() {
        return $this->vorname;
    }

    public function setVorname($vorname) {
        $this->vorname = $vorname;
    }

    public function getNachname() {
        return $this->nachname;
    }

    public function setNachname($nachname) {
        $this->nachname = $nachname;
    }

    public function getAdresse() {
        return $this->adresse;
    }

    public function setAdresse($adresse) {
        $this->adresse = $adresse;
    }

    public function getPlz() {
        return $this->plz;
    }

    public function setPlz($plz) {
        $this->plz = $plz;
    }

    public function getOrt() {
        return $this->ort;
    }

    public function setOrt($ort) {
        $this->ort = $ort;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
}
