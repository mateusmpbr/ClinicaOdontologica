<?php

namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\DentistaConsultaPaciente;
use ClinicaOdontologica\Models\Administrador;
use ClinicaOdontologica\Models\Recepcionista;

class ConsultaController
{
    private DentistaConsultaPaciente $dcp;

    public function __construct()
    {
        $this->dcp = new DentistaConsultaPaciente();
    }

    public function handleRequest(): array
    {
        $this->maybeHandleDelete();

        $consultas = $this->fetchAllConsultas();

        $sidebar = $this->determineSidebar();

        return [
            'consultas' => $consultas,
            'sidebar' => $sidebar,
            'dcp' => $this->dcp,
        ];
    }

    private function maybeHandleDelete(): void
    {
        if (function_exists('has_input') && has_input('botao-remover')) {
            $id = null;
            if (function_exists('input')) {
                $id = input('id', null);
            }

            if (!$id && function_exists('request')) {
                $req = request();
                $id = $req->getParsedBody()['id'] ?? $req->getQueryParams()['id'] ?? null;
            }

            if ($id) {
                $this->dcp->setId($id);
                $this->dcp->delete();
            }
        }
    }

    private function fetchAllConsultas(): array
    {
        $stmt = $this->dcp->viewAll();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    private function determineSidebar(): ?string
    {
        if (!isset($_SESSION['funcionario'])) {
            return null;
        }

        $a = new Administrador();
        $a->setFuncionarioId($_SESSION['funcionario']);
        if (!empty($a->viewAdministrador())) {
            return __DIR__ . '/../../views/Administrador/sidebar.php';
        }

        $r = new Recepcionista();
        $r->setFuncionarioId($_SESSION['funcionario']);
        if (!empty($r->viewRecepcionista())) {
            return __DIR__ . '/../../views/Recepcionista/sidebar.php';
        }

        return null;
    }
}
