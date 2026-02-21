<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function verificaFuncionarioLogado()
{
    if (!isset($_SESSION["funcionario"])) {
        header("Location: ../../index.php");
        exit;
    }
}

function verificaFuncionarioLogadoCadastro()
{
    if (!isset($_SESSION["funcionario"])) {
        header("Location: ../../../index.php");
        exit;
    }
}
function verificarAdministradorLogado()
{

    $a = new \ClinicaOdontologica\Models\Administrador();
    $a->setFuncionarioId($_SESSION['funcionario']);
    if (empty($a->viewAdministrador())) {
        header("Location: ../../index.php");
        exit;
    }
}

function verificarAdministradorLogadoCadastro()
{
    $a = new \ClinicaOdontologica\Models\Administrador();
    $a->setFuncionarioId($_SESSION['funcionario']);
    if (empty($a->viewAdministrador())) {
        header("Location: ../../../index.php");
        exit;
    }
}

function verificarRecepcionistaLogado()
{
    $r = new \ClinicaOdontologica\Models\Recepcionista();
    $r->setFuncionarioId($_SESSION['funcionario']);
    if (empty($r->viewRecepcionista())) {
        header("Location: ../../index.php");
        exit;
    }
}

function verificarRecepcionistaLogadoCadastro()
{
    $r = new \ClinicaOdontologica\Models\Recepcionista();
    $r->setFuncionarioId($_SESSION['funcionario']);
    if (empty($r->viewRecepcionista())) {
        header("Location: ../../../index.php");
        exit;
    }
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
