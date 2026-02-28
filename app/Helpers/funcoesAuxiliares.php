<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
use ClinicaOdontologica\Helpers\AuthGuard;

function verificaFuncionarioLogado()
{
    AuthGuard::ensureFuncionarioLogged(2);
}

function verificaFuncionarioLogadoCadastro()
{
    AuthGuard::ensureFuncionarioLogged(3);
}

function verificarAdministradorLogado()
{
    AuthGuard::ensureAdministradorLogged(2);
}

function verificarAdministradorLogadoCadastro()
{
    AuthGuard::ensureAdministradorLogged(3);
}

function verificarRecepcionistaLogado()
{
    AuthGuard::ensureRecepcionistaLogged(2);
}

function verificarRecepcionistaLogadoCadastro()
{
    AuthGuard::ensureRecepcionistaLogged(3);
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
