<?php
namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Recebimento;

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
                header('Location: recebimentos.php');
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
                'formAction' => 'recebimentos.php',
                'hiddenFields' => ['id' => $row->id],
                'confirmButtonName' => 'botao-remover',
                'confirmButtonLabel' => 'Remover',
            ];
        }

        return ['rows' => $rows, 'modals' => $modals];
    }
}
