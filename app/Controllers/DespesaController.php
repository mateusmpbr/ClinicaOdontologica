<?php
namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Despesa;

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
                header('Location: despesas.php');
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
                'formAction' => 'despesas.php',
                'hiddenFields' => ['id' => $row->id],
                'confirmButtonName' => 'botao-remover',
                'confirmButtonLabel' => 'Remover',
            ];
        }

        return ['rows' => $rows, 'modals' => $modals];
    }
}
