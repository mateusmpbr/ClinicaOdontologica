<?php

namespace ClinicaOdontologica\Helpers;

use AuthRole;
use ClinicaOdontologica\Models\Administrador;
use ClinicaOdontologica\Models\Recepcionista;


// Session is started in bootstrap.php; helpers assume session is active.

class AuthGuard
{
    public static function authenticateRole(AuthRole $requiredRole): void
    {
        // Prefer redirecting to role-specific index pages
        if (!empty($_SESSION['funcionario'])) {
            if($requiredRole === AuthRole::ADMIN){
                $a = new Administrador();
                $a->setFuncionarioId($_SESSION['funcionario']);
                if (empty($a->viewAdministrador())) {
                    header('Location: index.php');
                    exit;
                }
                return;
            }

            if($requiredRole === AuthRole::RECEPTIONIST){
                $r = new Recepcionista();
                $r->setFuncionarioId($_SESSION['funcionario']);
                if (empty($r->viewRecepcionista())) {
                    header('Location: index.php');
                    exit;
                }
                return;
            }
        }

        // Fallback to public index
        header('Location: index.php');
        exit;
    }

    public static function loginUser(string $nomeUsuario, string $senha): void
    {
        if (empty($nomeUsuario) || empty($senha)) {
            return;
        }
        
        $a = new Administrador();
        $a->setNomeUsuario($nomeUsuario);
        $funcionario_id = $a->existe($senha);

        if (!is_null($funcionario_id)) {
            $_SESSION["funcionario"] = $funcionario_id;
            header('Location: views/Administrador/index.php');
            exit;
        }
        
        $r = new Recepcionista();
        $r->setNomeUsuario($nomeUsuario);
        $funcionario_id = $r->existe($senha);

        if (!is_null($funcionario_id)) {
            $_SESSION["funcionario"] = $funcionario_id;
            header('Location: views/Recepcionista/index.php');
            exit;
        }
    }

        public static function redirectToIndex(): string
    {
        if (!isset($_SESSION['funcionario'])) {
            return "";
        }

        $a = new Administrador();
        $a->setFuncionarioId($_SESSION['funcionario']);
        if (!empty($a->viewAdministrador())) {
            return '/views/Administrador/index.php';
        }

        $r = new Recepcionista();
        $r->setFuncionarioId($_SESSION['funcionario']);
        if (!empty($r->viewRecepcionista())) {
            return '/views/Recepcionista/index.php';
        }

        return "";
    }
}
