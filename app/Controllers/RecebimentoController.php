<?php
namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Administrador;
use ClinicaOdontologica\Models\Recebimento;
use ClinicaOdontologica\Models\Recepcionista;

class RecebimentoController
{
    public function handleRequest(): array
    {
        $r = new Recebimento();

        if (function_exists('has_input') && has_input('botao-remover')) {
            $id = (request()->getParsedBody()['id'] ?? request()->getQueryParams()['id'] ?? null);
            if ($id) {
                $r->setId($id);
                $r->delete();
                header('Location: Recebimento.php');
                exit;
            }
        }

        $stmt = $r->viewAll();
        $rows = [];
        $modals = [];
        while ($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
            $r->setId($row->id);
            $row->recepcionista = $r->nomeRecepcionista();
            $row->paciente = $r->nomePaciente();
            $rows[] = $row;

            $modalId = "removeModal{$row->id}";
            $modals[] = [
                'modalId' => $modalId,
                'modalTitle' => "Você tem certeza que deseja remover?",
                'modalBody' => 'Essa ação não poderá ser desfeita',
                'formAction' => 'Recebimento.php',
                'hiddenFields' => ['id' => $row->id],
                'confirmButtonName' => 'botao-remover',
                'confirmButtonLabel' => 'Remover',
            ];
        }

        $sidebar = $this->determineSidebar();

        return ['rows' => $rows, 'modals' => $modals, 'sidebar' => $sidebar];
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
