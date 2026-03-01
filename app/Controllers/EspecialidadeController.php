<?php

namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Administrador;
use ClinicaOdontologica\Models\Especialidade;
use ClinicaOdontologica\Models\Recepcionista;

class EspecialidadeController
{
    public function handleRequest(): array
    {
        $e = new Especialidade();
        $stmt = $e->viewAll();
        $especialidades = $stmt->fetchAll(\PDO::FETCH_OBJ);

        // handle delete
        if (function_exists('has_input') && has_input('botao-remover')) {
            $nome = input('nome', null);
            if ($nome) {
                $e->setNome($nome);
                $e->delete();
                header('Location: Especialidade.php');
                exit;
            }
        }

        $sidebar = $this->determineSidebar();

        return ['especialidades' => $especialidades, 'sidebar' => $sidebar];
    }

            private function determineSidebar(): ?string
    {
        if (!isset($_SESSION['funcionario'])) {
            return null;
        }

        $a = new Administrador();
        $a->setFuncionarioId($_SESSION['funcionario']);
        if (!empty($a->viewAdministrador())) {
            return __DIR__ . '/../../views/Administrador/Sidebar.php';
        }

        $r = new Recepcionista();
        $r->setFuncionarioId($_SESSION['funcionario']);
        if (!empty($r->viewRecepcionista())) {
            return __DIR__ . '/../../views/Recepcionista/Sidebar.php';
        }

        return null;
    }
}
