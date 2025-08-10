<?php
require_once 'config/security.php';
require_once 'config/jwt.php';

setSecurityHeaders();

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-Type');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

define('ROOT_PATH', __DIR__);

function getProjectPath($relativePath) {
    return ROOT_PATH . '/' . ltrim($relativePath, '/');
}

if (!isset($_COOKIE['client']) || !isset($_COOKIE['client_secure'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Client non authentifié']);
    exit;
}

$client = $_COOKIE['client'];
$secureToken = $_COOKIE['client_secure'];

if (!in_array($client, ['clienta', 'clientb', 'clientc'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Client invalide']);
    exit;
}

$payload = validateJWT($secureToken);
if (!$payload || !isset($payload['client']) || $payload['client'] !== $client) {
    http_response_code(401);
    echo json_encode(['error' => 'Token de sécurité invalide']);
    exit;
}

$module = $_GET['module'] ?? 'cars';
$script = $_GET['script'] ?? 'list';

$params = ['client' => $client, 'module' => $module, 'script' => $script];
$params = sanitizeInput($params);

if (!validateRequestParams($params)) {
    http_response_code(400);
    echo json_encode(['error' => 'Paramètres invalides ou accès refusé']);
    exit;
}

$filePath = getProjectPath("customs/{$client}/modules/{$module}/{$script}.php");

if (!file_exists($filePath)) {
    http_response_code(404);
    echo json_encode(['error' => 'Module ou script non trouvé']);
    exit;
}

ob_start();
include $filePath;
$content = ob_get_clean();

echo json_encode([
    'success' => true,
    'content' => $content,
    'client' => $client,
    'module' => $module,
    'script' => $script
]);
