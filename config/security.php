<?php
function setSecurityHeaders() {
    header('X-Frame-Options: DENY');
    header('X-Content-Type-Options: nosniff');
    header('X-XSS-Protection: 1; mode=block');
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline';");
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
}

function validateRequestParams($params) {
    if (!isset($params['client']) || !in_array($params['client'], ['clienta', 'clientb', 'clientc'])) {
        return false;
    }
    if (!isset($params['module']) || !in_array($params['module'], ['cars', 'garage'])) {
        return false;
    }
    if (!isset($params['script']) || !in_array($params['script'], ['list', 'edit'])) {
        return false;
    }
    if ($params['client'] !== 'clientb' && $params['module'] === 'garage') {
        return false;
    }
    return true;
}

function sanitizeInput($input) {
    if (is_array($input)) {
        return array_map('sanitizeInput', $input);
    }
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}
