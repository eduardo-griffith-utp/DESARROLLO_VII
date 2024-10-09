<?php
class ProductResource {
    private $db;
    private $auth;

    public function __construct($db, $auth) {
        $this->db = $db;
        $this->auth = $auth;
    }

    public function get($args) {
        if (isset($args[0])) {
            $product = $this->db->query("SELECT * FROM products WHERE id = ?", [$args[0]])->fetch(PDO::FETCH_ASSOC);
            if ($product) {
                return $product;
            }
            throw new Exception("Product not found", 404);
        }
        return $this->db->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        $requiredFields = ['name', 'price'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                throw new Exception("Missing required field: $field", 400);
            }
        }
        $this->db->query("INSERT INTO products (name, price) VALUES (?, ?)", 
            [$data['name'], $data['price']]);
        return ["id" => $this->db->lastInsertId(), "message" => "Product created successfully"];
    }
}