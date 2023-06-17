<?php

include_once '../data/ProductDAO.php';
include_once '../data/UserDAO.php';
include_once '../data/CartDAO.php';
class API {
    private $productDAO;
    private $userDAO;
    private $cartDAO;
    
    public function __construct() {
        $this->productDAO = new ProductDAO();
        $this->userDAO = new UserDAO();
        $this->cartDAO = new CartDAO();
        $this->processRequest();
    }
    
    public function processRequest() {
        $request_method = $_SERVER["REQUEST_METHOD"];
        switch ($request_method) {
            case 'POST':
                $this->handlePost();
                break;
            case 'GET':
                $this->handleGet();
                break;
            default:
                $this->respond(500, "Invalid Request");
                break;
        }
    }

    public function handleGet() {
        try {
            $response = null;

            $type = isset($_GET['type']) ? $_GET['type'] : '';

            switch ($type) {
                case 'products':
                    $response = $this->productDAO->getProducts();
                    break;
                case 'productsByCategory':
                    $kategorie = isset($_GET['kategorie']) ? $_GET['kategorie'] : '';
                    $response = $this->productDAO->getProductsByCategory($kategorie);
                    break;
                case 'users':
                    $response = $this->userDAO->getUsers();
                    break;
                default:
                    $response = null;
                    break;
            }

            if ($response !== null) {
                $this->respond(200, $response);
            } else {
                $this->respond(500, array('status' => 'error', 'message' => 'Error retrieving data'));
            }
        } catch (Exception $e) {
            $this->respond(500, array('status' => 'error', 'message' => $e->getMessage()));
        }
    }

    public function handlePost() {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data === null) {
            $this->respond(400, "Invalid JSON data");
            return;
        }
    
        $request_type = isset($data['request_type']) ? $data['request_type'] : '';
    
        switch ($request_type) {
            case 'login':
                $this->handleLogin($data);
                break;
            case 'register':
                $this->handleRegister($data);
                break;
            case 'add_to_cart':
                $this->handleAddToCart($data);
                break;
            default:
                $this->respond(400, "Invalid request type");
                break;
        }
    }
    
    public function handleLogin($data) {
        $username = $data['username'];
        $password = $data['password'];
    
        // Retrieve the user from the database using the provided username
        $user = $this->userDAO->getUserByUsernameOrEmail($username);
    
        if ($user !== null && $this->userDAO->verifyPassword($password, $user['password'])) {
            // User found and password matches, create a session
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['loggedin'] = true;
    
            // Return success response
            $this->respond(200, array('status' => 'success', 'message' => 'Login successful'));
        } else {
            // User not found or password does not match, return error response
            $this->respond(401, array('status' => 'error', 'message' => 'Invalid username or password'));
        }
    }

    public function handleRegister($data) {
        $response = $this->userDAO->insertUser($data);
        if ($response !== null) {
            $this->respond(200, array('status' => 'success', 'message' => 'Registration successful'));
        } else {
            $this->respond(500, array('status' => 'error', 'message' => 'Error processing data'));
        }
    }

    public function handleAddToCart($data) {
        $productId = isset($data['product_id']) ? $data['product_id'] : '';

        if (!empty($productId)) {
            $response = $this->cartDAO->addToCart($productId);
            if ($response === true) {
                $cartCount = $this->cartDAO->getCartCount();
                $this->respond(200, array('status' => 'success', 'message' => 'Product added to cart', 'cart_count' => $cartCount));
            } else {
                $this->respond(500, array('status' => 'error', 'message' => 'Failed to add product to cart'));
            }
        } else {
            $this->respond(400, array('status' => 'error', 'message' => 'Invalid product ID'));
        }
    }
    
    public function respond($status, $data = null) {
        // Set CORS headers
        header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
        header("Access-Control-Allow-Methods: GET, POST"); // Allow GET and POST methods
        header("Access-Control-Allow-Headers: Content-Type"); // Allow the Content-Type header
        
        http_response_code($status);
        header("Content-Type: application/json;charset=utf-8");
        
        if ($data !== null) {
            echo json_encode($data);
        }
    }
}

$api = new API();
?>