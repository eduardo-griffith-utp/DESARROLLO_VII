<?php
class AuthController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function validateApiKey() {
        $headers = getallheaders();
        error_log('Headers: ' . print_r($headers, true)); // Debug log
        $apiKey = $headers['X-API-Key'] ?? null;
        if (!$apiKey) {
            throw new Exception("API Key required", 401);
        }
        $stmt = $this->db->prepare("SELECT * FROM clients WHERE api_key = ?");
        $stmt->execute([$apiKey]);
        $client = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$client) {
            throw new Exception("Invalid API Key", 401);
        }
        return $client;
    }

    public function validateJWTToken() {
        $headers = getallheaders();
        error_log('Headers: ' . print_r($headers, true)); // Debug log
        $auth = $headers['Authorization'] ?? '';
        if (!preg_match('/Bearer\s(\S+)/', $auth, $matches)) {
            throw new Exception("Bearer token required", 401);
        }
        $jwt = $matches[1];
        error_log('JWT Token: ' . $jwt); // Debug log
        $token = $this->decodeJWT($jwt);
        if (!$token) {
            throw new Exception("Invalid token", 401);
        }
        return $token;
    }

    public function generateJWTToken($userId) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;  // Valid for 1 hour
        $payload = array(
            'user_id' => $userId,
            'iat' => $issuedAt,
            'exp' => $expirationTime
        );
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $base64UrlHeader = $this->base64UrlEncode($header);
        $base64UrlPayload = $this->base64UrlEncode(json_encode($payload));
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, JWT_SECRET, true);
        $base64UrlSignature = $this->base64UrlEncode($signature);
        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    private function decodeJWT($jwt) {
        $tokenParts = explode('.', $jwt);
        if (count($tokenParts) != 3) {
            return null;
        }

        $payload = json_decode($this->base64UrlDecode($tokenParts[1]), true);
        if (!$payload) {
            return null;
        }

        if (isset($payload['exp']) && $payload['exp'] < time()) {
            return null;
        }

        $signature = $this->base64UrlDecode($tokenParts[2]);
        $base64UrlHeader = $this->base64UrlEncode($this->base64UrlDecode($tokenParts[0]));
        $base64UrlPayload = $this->base64UrlEncode($this->base64UrlDecode($tokenParts[1]));
        $verified = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, JWT_SECRET, true) === $signature;

        return $verified ? $payload : null;
    }

    private function base64UrlEncode($data) {
        $base64 = base64_encode($data);
        $base64Url = strtr($base64, '+/', '-_');
        return rtrim($base64Url, '=');
    }

    private function base64UrlDecode($data) {
        $base64Url = strtr($data, '-_', '+/');
        $base64 = str_pad($base64Url, strlen($data) % 4, '=', STR_PAD_RIGHT);
        return base64_decode($base64);
    }
}