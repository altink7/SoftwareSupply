<?php

include_once '../db/Database.php';

class API {
    private $dataHandler;
    
    public function __construct() {
        $this->dataHandler = new Database();
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
            default:
                $this->respond(400, "Invalid request type");
                break;
        }
    }
    
    public function handleLogin($data) {
        $username = $data['username'];
        $password = $data['password'];
    
        // Retrieve the user from the database using the provided username
        $user = $this->dataHandler->getUserByUsername($username);
    
        if ($user !== null && $this->dataHandler->verifyPassword($password, $user['password'])) {
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
        $data = json_decode(file_get_contents("php://input"), true);
        if ($data === null) {
            $this->respond(400, "Invalid JSON data");
            return;
        }
        $response = $this->dataHandler->insertUser($data);
        if ($response !== null) {
            $this->respond(200, array('status' => 'success', 'message' => $response));
        } else {
            $this->respond(500, array('status' => 'error', 'message' => 'Error processing data'));
        }
        $this->respond(200, array('status' => 'success', 'message' => 'Registration successful'));
    }
    
    public function handleGet() {
        $response = $this->dataHandler->getUsers();
        if ($response !== null) {
            $this->respond(200, $response);
        } else {
            $this->respond(500, "Error retrieving data");
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
