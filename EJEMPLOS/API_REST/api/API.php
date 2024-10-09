<?php
require_once 'Database.php';
require_once 'AuthController.php';
require_once 'resources/UserResource.php';
require_once 'resources/ProductResource.php';

class API {
    protected $method = '';
    protected $endpoint = '';
    protected $params = array();
    protected $db;
    protected $auth;

    public function __construct($request) {
        $this->args = explode('/', rtrim($request, '/'));
        $this->endpoint = array_shift($this->args);
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->db = new Database();
        $this->auth = new AuthController($this->db);
    }

    public function processAPI() {
        if (method_exists($this, $this->endpoint)) {
            return $this->_response($this->{$this->endpoint}());
        }
        return $this->_response("No Endpoint: $this->endpoint", 404);
    }

    protected function _response($data, $status = 200) {
        header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
        header("Content-Type: application/json");
        echo json_encode($data);
        exit;
    }

    private function _requestStatus($code) {
        $status = array(
            200 => 'OK',
            201 => 'Created',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return ($status[$code])?$status[$code]:$status[500];
    }

    protected function users() {
        $resource = new UserResource($this->db, $this->auth);
        switch($this->method) {
            case 'GET':
                $this->auth->validateApiKey();
                return $resource->get($this->args);
            case 'POST':
                $this->auth->validateApiKey();
                return $resource->create();
            default:
                return $this->_response("Method not allowed", 405);
        }
    }

    protected function products() {
        $resource = new ProductResource($this->db, $this->auth);
        switch($this->method) {
            case 'GET':
                try {
                    $this->auth->validateJWTToken();
                    return $resource->get($this->args);
                } catch (Exception $e) {
                    return $this->_response($e->getMessage(), $e->getCode());
                }
            case 'POST':
                try {
                    $this->auth->validateJWTToken();
                    return $resource->create();
                } catch (Exception $e) {
                    return $this->_response($e->getMessage(), $e->getCode());
                }
            default:
                return $this->_response("Method not allowed", 405);
        }
    }

    protected function login() {
        if ($this->method !== 'POST') {
            return $this->_response("Method not allowed", 405);
        }
        $data = json_decode(file_get_contents("php://input"), true);
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        
        $stmt = $this->db->prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user && password_verify($password, $user['password'])) {
            $token = $this->auth->generateJWTToken($user['id']);
            return $this->_response(['token' => $token]);
        } else {
            return $this->_response("Invalid credentials", 401);
        }
    }
}