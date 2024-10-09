<?php
class UserResource {
    private $db;
    private $auth;

    public function __construct($db, $auth) {
        $this->db = $db;
        $this->auth = $auth;
    }

    public function get($args) {
        if (isset($args[0])) {
            $user = $this->db->query("SELECT id, name, email FROM users WHERE id = ?", [$args[0]])->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                return $user;
            }
            throw new Exception("User not found", 404);
        }
        return $this->db->query("SELECT id, name, email FROM users")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);
        $requiredFields = ['name', 'email', 'password'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                throw new Exception("Missing required field: $field", 400);
            }
        }
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->db->query("INSERT INTO users (name, email, password) VALUES (?, ?, ?)", 
            [$data['name'], $data['email'], $hashedPassword]);
        return ["id" => $this->db->lastInsertId(), "message" => "User created successfully"];
    }
}