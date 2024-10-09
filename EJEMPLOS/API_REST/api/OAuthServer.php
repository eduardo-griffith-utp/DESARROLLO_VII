<?php
class OAuthServer {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function handleTokenRequest() {
        $grantType = $_POST['grant_type'] ?? '';
        switch ($grantType) {
            case 'client_credentials':
                return $this->handleClientCredentials();
            case 'authorization_code':
                return $this->handleAuthorizationCode();
            default:
                throw new Exception("Unsupported grant type", 400);
        }
    }

    private function handleClientCredentials() {
        $clientId = $_POST['client_id'] ?? '';
        $clientSecret = $_POST['client_secret'] ?? '';
        $client = $this->db->query("SELECT * FROM oauth_clients WHERE client_id = ? AND client_secret = ?", [$clientId, $clientSecret])->fetch(PDO::FETCH_ASSOC);
        if (!$client) {
            throw new Exception("Invalid client credentials", 401);
        }
        $accessToken = $this->generateAccessToken($client['id']);
        return [
            'access_token' => $accessToken,
            'token_type' => 'Bearer',
            'expires_in' => 3600
        ];
    }

    private function handleAuthorizationCode() {
        // Implementación del flujo de código de autorización
        // Este es un proceso más complejo que implica múltiples pasos
        throw new Exception("Authorization Code grant not implemented", 501);
    }

    private function generateAccessToken($clientId) {
        $token = bin2hex(random_bytes(32));
        $expiresAt = time() + 3600; // 1 hora de validez
        $this->db->query("INSERT INTO oauth_access_tokens (access_token, client_id, expires_at) VALUES (?, ?, ?)", [$token, $clientId, $expiresAt]);
        return $token;
    }
}