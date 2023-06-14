<?php class Product {
    private $id;
    private $title;
    private $description;
    private $price;
    private $review;
    private $fkCustomer;
    private $date;

    // Constructor
    public function __construct($id, $title, $description, $price, $review, $fkCustomer, $date) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->review = $review;
        $this->fkCustomer = $fkCustomer;
        $this->date = $date;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getReview() {
        return $this->review;
    }

    public function getFkCustomer() {
        return $this->fkCustomer;
    }

    public function getDate() {
        return $this->date;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setReview($review) {
        $this->review = $review;
    }

    public function setFkCustomer($fkCustomer) {
        $this->fkCustomer = $fkCustomer;
    }

    public function setDate($date) {
        $this->date = $date;
    }
}

?>
