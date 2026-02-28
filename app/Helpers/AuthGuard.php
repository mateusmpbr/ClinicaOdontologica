<?php

namespace ClinicaOdontologica\Helpers;

use ClinicaOdontologica\Models\Administrador;
use ClinicaOdontologica\Models\Recepcionista;

class AuthGuard
{
    private static function redirectToIndex(int $levels)
    {
        $prefix = str_repeat('../', $levels);
        header("Location: {$prefix}index.php");
        exit;
    }

    public static function ensureFuncionarioLogged(int $levels = 2): void
    {
        if (!isset($_SESSION['funcionario'])) {
            self::redirectToIndex($levels);
        }
    }

    public static function ensureAdministradorLogged(int $levels = 2): void
    {
        if (!isset($_SESSION['funcionario'])) {
            self::redirectToIndex($levels);
        }

        $a = new Administrador();
        $a->setFuncionarioId($_SESSION['funcionario']);
        if (empty($a->viewAdministrador())) {
            self::redirectToIndex($levels);
        }
    }

    public static function ensureRecepcionistaLogged(int $levels = 2): void
    {
        if (!isset($_SESSION['funcionario'])) {
            self::redirectToIndex($levels);
        }

        $r = new Recepcionista();
        $r->setFuncionarioId($_SESSION['funcionario']);
        if (empty($r->viewRecepcionista())) {
            self::redirectToIndex($levels);
        }
    }
}
