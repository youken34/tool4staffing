<?php
require_once 'config/security.php';
require_once 'config/jwt.php';
setSecurityHeaders();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-Type');
header('Access-Control-Allow-Methods: POST, OPTIONS');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['client'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Client requis']);
    exit;
}

$client = $input['client'];

$validClients = ['clienta', 'clientb', 'clientc'];
if (!in_array($client, $validClients)) {
    http_response_code(400);
    echo json_encode(['error' => 'Client invalide']);
    exit;
}

$payload = [
    'client' => $client,
    'timestamp' => time(),
    'session_id' => uniqid()
];

$token = generateJWT($payload);

setcookie('client', $client, [
    'expires' => time() + 3600, 
    'path' => '/',
    'secure' => true, 
    'httponly' => true,
    'samesite' => 'Strict'
]);

setcookie('client_secure', $token, [
    'expires' => time() + 3600,
    'path' => '/',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);

echo json_encode([
    'success' => true,
    'client' => $client,
    'message' => 'Authentification réussie'
]);
?> 