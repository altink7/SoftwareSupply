<?php

include_once '../data/ProductDAO.php';
include_once '../data/UserDAO.php';
include_once '../data/CartDAO.php';
include_once '../data/OrderDAO.php';

class API {
    private $productDAO;
    private $userDAO;
    private $cartDAO;
    private $orderDAO;
    
    public function __construct() {
        $this->productDAO = new ProductDAO();
        $this->userDAO = new UserDAO();
        $this->cartDAO = new CartDAO();
        $this->orderDAO = new OrderDAO();
        $this->processRequest();
    }
    
    public function processRequest() {
        session_set_cookie_params(3600); // Set the cookie lifetime to 1 hour (3600 seconds)
        session_start();
        $request_method = $_SERVER["REQUEST_METHOD"];
        switch ($request_method) {
            case 'POST':
                $this->handlePost();
                break;
            case 'GET':
                $this->handleGet();
                break;
            case 'DELETE':
                $this->handleDelete();
                break;
            default:
                $this->respond(500, "Invalid Request");
                break;
        }
    }

    public function handleGet() {
        try {
            $type = isset($_GET['type']) ? $_GET['type'] : '';
            $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
    
            switch ($type) {
                case 'products':
                    $response = $this->productDAO->getProducts();
                    break;
                case 'productsByCategory':
                    $kategorie = isset($_GET['kategorie']) ? $_GET['kategorie'] : '';
                    $response = $this->productDAO->getProductsByCategory($kategorie);
                    break;
                case 'productsBySearch':
                    $keyword = isset($_GET['search']) ? $_GET['search'] : '';
                    $response = $this->productDAO->searchProducts($keyword);
                    break;
                case 'users':
                    $response = $this->userDAO->getUsers();
                    break;
                case 'cart':
                    $response = $this->cartDAO->getCartData($this->userDAO->getUserIdByUsername($username));
                    break;
                case 'cartCount':
                    $response = $this->cartDAO->getCartCount($this->userDAO->getUserIdByUsername($username));
                    break;
                case 'login_status':
                    $response = $this->checkLoginStatus();
                    break;
                case 'get_orders_for_user':
                    $response = $this->orderDAO->getOrdersForUser($this->userDAO->getUserIdByUsername($username));
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
            case 'update_quantity':
                $this->handleUpdateQuantity($data);
                break;
            case 'logout':
                $this->handleLogout();
                break;
            case 'update_profile':
                $this->handleUpdateProfile($data);
                break;
            case 'remove_product':
                $this->handleRemoveProduct($data);
                break;
            case 'save_order':
                $this->handleSaveOrder($data);
                break;
            case 'save_order_positions':
                $this->handleSaveOrderPositions($data);
                break;
            default:
                $this->respond(400, "Invalid request type");
                break;
        }
    }

    public function handleDelete() {
        try {
            $type = isset($_GET['type']) ? $_GET['type'] : '';
            $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

            switch ($type) {
                case 'cart':
                    $response = $this->cartDAO->deleteCartData($this->userDAO->getUserIdByUsername($username));
                    break;
                default:
                    $response = null;
                    break;
            }

            if ($response === true) {
                $this->respond(200, array('status' => 'success', 'message' => 'Data deleted successfully'));
            } else {
                $this->respond(500, array('status' => 'error', 'message' => 'Failed to delete data'));
            }
        } catch (Exception $e) {
            $this->respond(500, array('status' => 'error', 'message' => $e->getMessage()));
        }
    }




    public function handleLogin($data) {
        $username = $data['username'];
        $password = $data['password'];
        $rememberMe = isset($data['remember_me']) && $data['remember_me'] === true;
    
        // Retrieve the user from the database using the provided username
        $user = $this->userDAO->getUserByUsernameOrEmail($username);
    
        if ($user !== null && $this->userDAO->verifyPassword($password, $user['password'])) {
            // User found and password matches, create a session
            $_SESSION['username'] = $username;
            $_SESSION['loggedin'] = true;

            // Set session cookie lifetime
            if ($rememberMe) {
                $cookieLifetime = 604800; // 1 week in seconds
                session_set_cookie_params($cookieLifetime);
            }
    
            // Return success response
            $this->respond(200, array('status' => 'success', 'message' => 'Login successful'));
        } else {
            // User not found or password does not match, return error response
            $this->respond(401, array('status' => 'error', 'message' => 'Invalid username or password'));
        }
    }

    public function handleLogout() {
        // Clear session data
        $_SESSION = array();
        session_destroy();

        $this->respond(200, array('status' => 'success', 'message' => 'Logout successful'));
    }

    public function handleRegister($data) {
        $response = $this->userDAO->insertUser($data);
        if ($response !== null) {
            $this->respond(200, array('status' => 'success', 'message' => 'Registration successful'));
        } else {
            $this->respond(500, array('status' => 'error', 'message' => 'Error processing data'));
        }
    }

    public function handleUpdateProfile($data) {
        $username = $_SESSION['username'];
        $updatedData = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'address' => $data['address'],
            'postal_code' => $data['postal_code'],
            'city' => $data['city'],
            'password' => $data['password'],
            'payment' => $data['payment']
        ];

        $result = $this->userDAO->updateUserProfile($username, $updatedData);

        if ($result) {
            $this->respond(200, array('status' => 'success', 'message' => 'Profile updated successfully'));
        } else {
            $this->respond(500, array('status' => 'error', 'message' => 'Failed to update profile'));
        }
    }

    public function handleAddToCart($data) {
        $productId = isset($data['product_id']) ? $data['product_id'] : '';
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

        if (!empty($productId)) {
            $response = $this->cartDAO->addToCart($productId, $this->userDAO->getUserIdByUsername($username));
            if ($response === true) {
                $cartCount = $this->cartDAO->getCartCount($this->userDAO->getUserIdByUsername($username));
                $this->respond(200, array('status' => 'success', 'message' => 'Product added to cart', 'cart_count' => $cartCount));
            } else {
                $this->respond(500, array('status' => 'error', 'message' => 'Failed to add product to cart'));
            }
        } else {
            $this->respond(400, array('status' => 'error', 'message' => 'Invalid product ID'));
        }
    }

    public function handleRemoveProduct($data) {
        $productId = isset($data['product_id']) ? $data['product_id'] : '';
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

        if (!empty($productId)) {
            $response = $this->cartDAO->removeProduct($this->userDAO->getUserIdByUsername($username), $productId);
            if ($response === true) {
                $cartCount = $this->cartDAO->getCartCount($this->userDAO->getUserIdByUsername($username));
                $this->respond(200, array('status' => 'success', 'message' => 'Product removed from cart', 'cart_count' => $cartCount));
            } else {
                $this->respond(500, array('status' => 'error', 'message' => 'Failed to remove product from cart'));
            }
        } else {
            $this->respond(400, array('status' => 'error', 'message' => 'Invalid product ID'));
        }
    }

    public function handleUpdateQuantity($data) {
        $productId = isset($data['product_id']) ? $data['product_id'] : '';
        $quantity = isset($data['quantity']) ? intval($data['quantity']) : 0;
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

        if (!empty($productId) && $quantity > 0) {
            $response = $this->cartDAO->updateQuantity($this->userDAO->getUserIdByUsername($username), $productId, $quantity);
            if ($response === true) {
                $this->respond(200, array('status' => 'success', 'message' => 'Quantity updated successfully'));
            } else {
                $this->respond(500, array('status' => 'error', 'message' => 'Failed to update quantity'));
            }
        } else {
            $this->respond(400, array('status' => 'error', 'message' => 'Invalid product ID or quantity'));
        }
    }


    public function checkLoginStatus() {
        $loggedIn = $_SESSION['loggedin'] === true;
        $userProfile = null;
    
        if ($loggedIn) {
            $username = $_SESSION['username'];
            $userProfile = $this->userDAO->getUserProfile($username);
        }
    
        return array('logged_in' => $loggedIn, 'user_profile' => $userProfile);
    }

    public function handleSaveOrder($data) {
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
        $totalPrice = isset($data['total_price']) ? $data['total_price'] : 0;
        $userId = $this->userDAO->getUserIdByUsername($username);
        $orderId = $this->orderDAO->saveOrder($totalPrice, $userId);

        if ($orderId !== null) {
            $this->respond(200, array('status' => 'success', 'order_id' => $orderId));
        } else {
            $this->respond(500, array('status' => 'error', 'message' => 'Error saving order'));
        }
    }

    public function handleSaveOrderPositions($data) {
        $orderId = isset($data['order_id']) ? $data['order_id'] : '';
        $positions = isset($data['positions']) ? $data['positions'] : [];

        if (!empty($orderId) && !empty($positions)) {
            $success = true;
            foreach ($positions as $position) {
                $title = isset($position['title']) ? $position['title'] : '';
                $productId = $this->productDAO->getProductIdByTitle($title);
                $quantity = isset($position['quantity']) ? $position['quantity'] : 0;

                if (!empty($productId) && is_numeric($quantity)) {
                    $result = $this->orderDAO->saveOrderPosition($orderId, $productId, $quantity);
                    if (!$result) {
                        $success = false;
                        break;
                    }
                } else {
                    $success = false;
                    break;
                }
            }

            if ($success) {
                $this->respond(200, array('status' => 'success', 'message' => 'Order positions saved successfully'));
            } else {
                $this->respond(500, array('status' => 'error', 'message' => 'Error saving order positions'));
            }
        } else {
            $this->respond(400, array('status' => 'error', 'message' => 'Invalid request data'));
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

