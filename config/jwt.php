<?php
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        putenv(trim($name) . '=' . trim($value));
    }
}

define('JWT_SECRET', getenv('JWT_SECRET'));
define('JWT_ALGORITHM', 'HS256');
define('JWT_EXPIRATION', 3600);

function base64UrlEncode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64UrlDecode($data) {
    return base64_decode(strtr($data, '-_', '+/'));
}

function generateJWT($payload) {
    $header = json_encode(['typ' => 'JWT', 'alg' => JWT_ALGORITHM]);
    $payload['iat'] = time();
    $payload['exp'] = time() + JWT_EXPIRATION;

    $base64Header = base64UrlEncode($header);
    $base64Payload = base64UrlEncode(json_encode($payload));

    $signature = hash_hmac('sha256', "$base64Header.$base64Payload", JWT_SECRET, true);
    $base64Signature = base64UrlEncode($signature);

    return "$base64Header.$base64Payload.$base64Signature";
}

function validateJWT($token) {
    $parts = explode('.', $token);
    if (count($parts) !== 3) {
        return false;
    }

    list($header, $payload, $signature) = $parts;

    $expectedSignature = base64UrlEncode(hash_hmac('sha256', "$header.$payload", JWT_SECRET, true));
    if (!hash_equals($signature, $expectedSignature)) {
        return false;
    }

    $payload = json_decode(base64UrlDecode($payload), true);

    if (!isset($payload['exp']) || $payload['exp'] < time()) {
        return false;
    }

    if (isset($payload['nbf']) && $payload['nbf'] > time()) {
        return false;
    }

    return $payload;
}

function getJWTFromRequest() {
    $headers = getallheaders();
    if (isset($headers['Authorization'])) {
        if (preg_match('/Bearer\s+(\S+)/i', $headers['Authorization'], $matches)) {
            return $matches[1];
        }
    }

    if (isset($_COOKIE['auth_token'])) {
        return $_COOKIE['auth_token'];
    }

    return null;
}

function isAuthenticated() {
    $token = getJWTFromRequest();
    if (!$token) {
        return false;
    }

    $payload = validateJWT($token);
    return $payload !== false;
}

function getClientFromJWT() {
    $token = getJWTFromRequest();
    if (!$token) {
        return null;
    }

    $payload = validateJWT($token);
    if (!$payload || !isset($payload['client'])) {
        return null;
    }

    return $payload['client'];
}
?>
