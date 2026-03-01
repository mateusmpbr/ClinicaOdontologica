<?php
namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Administrador;
use ClinicaOdontologica\Models\Despesa;
use ClinicaOdontologica\Models\Recepcionista;

class DespesaController
{
    public function handleRequest(): array
    {
        $d = new Despesa();

        if (function_exists('has_input') && has_input('botao-remover')) {
            $id = (request()->getParsedBody()['id'] ?? request()->getQueryParams()['id'] ?? null);
            if ($id) {
                $d->setId($id);
                $d->delete();
                header('Location: Despesa.php');
                exit;
            }
        }

        $stmt = $d->viewAll();
        $rows = [];
        $modals = [];
        while ($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
            $d->setId($row->id);
            $row->administrador = $d->nomeAdministrador();
            $rows[] = $row;

            $modalId = "removeModal{$row->id}";
            $modals[] = [
                'modalId' => $modalId,
                'modalTitle' => "Você tem certeza que deseja remover a despesa {$row->nome}?",
                'modalBody' => 'Essa ação não poderá ser desfeita',
                'formAction' => 'Despesa.php',
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
