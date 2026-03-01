<?php

// Session is started in bootstrap.php; helpers assume session is active.
use ClinicaOdontologica\Helpers\AuthGuard;

enum AuthRole {
    case ADMIN;
    case RECEPTIONIST;
} 

function autenticar(AuthRole $requiredRole)
{
    AuthGuard::authenticateRole($requiredRole);
}

// Request helpers to ease migration to PSR-7
if (!function_exists('input')) {
    function input(string $key, $default = null)
    {
        if (function_exists('request')) {
            $req = request();
            $body = $req->getParsedBody() ?: [];
            $query = $req->getQueryParams() ?: [];
            $data = array_merge($query, is_array($body) ? $body : []);
            return $data[$key] ?? $default;
        }

        return $_REQUEST[$key] ?? $default;
    }
}

if (!function_exists('has_input')) {
    function has_input(string $key): bool
    {
        if (function_exists('request')) {
            $req = request();
            $body = $req->getParsedBody() ?: [];
            $query = $req->getQueryParams() ?: [];
            $data = array_merge($query, is_array($body) ? $body : []);
            return array_key_exists($key, $data);
        }

        return array_key_exists($key, $_REQUEST);
    }
}

if (!function_exists('server_param')) {
    function server_param(string $key, $default = null)
    {
        if (function_exists('request')) {
            $req = request();
            $server = $req->getServerParams() ?: [];
            return $server[$key] ?? $default;
        }

        return $_SERVER[$key] ?? $default;
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token(): string
    {
        // session should already be active from bootstrap
        if (empty($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf_token'];
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field(): string
    {
        $token = htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8');
        return '<input type="hidden" name="_csrf_token" value="' . $token . '">';
    }
}

if (!function_exists('validate_csrf')) {
    function validate_csrf(): bool
    {
        // session should already be active from bootstrap
        $posted = $_POST['_csrf_token'] ?? null;
        if (empty($posted) || empty($_SESSION['_csrf_token'])) {
            return false;
        }
        $valid = hash_equals($_SESSION['_csrf_token'], $posted);
        if ($valid) {
            // rotate token after successful validation
            unset($_SESSION['_csrf_token']);
        }
        return $valid;
    }
}
