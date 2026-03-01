<?php
namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Administrador;
use ClinicaOdontologica\Models\AuxiliarAuxiliaDentista;
use ClinicaOdontologica\Models\Recepcionista;

class AuxilioController
{
    public function handleRequest(): array
    {
        $aad = new AuxiliarAuxiliaDentista();

        if (function_exists('has_input') && has_input('botao-remover')) {
            $dentista_id = (request()->getParsedBody()['dentista_id'] ?? request()->getQueryParams()['dentista_id'] ?? null);
            $auxiliar_id = (request()->getParsedBody()['auxiliar_id'] ?? request()->getQueryParams()['auxiliar_id'] ?? null);
            if ($dentista_id && $auxiliar_id) {
                $aad->setDentistaId($dentista_id);
                $aad->setAuxiliarId($auxiliar_id);
                $aad->delete();
                header('Location: Auxilio.php');
                exit;
            }
        }

        $stmt = $aad->viewAll();
        $rows = [];
        while ($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
            $row->dentista_nome = $aad->nomeDentista($row->dentista_id, $row->auxiliar_id);
            $row->auxiliar_nome = $aad->nomeAuxiliar($row->dentista_id, $row->auxiliar_id);
            $rows[] = $row;
        }

        $sidebar = $this->determineSidebar();

        return ['rows' => $rows, 'sidebar' => $sidebar];
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
