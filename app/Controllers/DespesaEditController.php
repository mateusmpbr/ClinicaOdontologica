<?php
namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Despesa;

class DespesaEditController
{
    public function handleRequest(): array
    {
        $d = new Despesa();

        if (function_exists('has_input') && has_input('botao')) {
            $id = (request()->getParsedBody()['id'] ?? request()->getQueryParams()['id'] ?? null);
            $descricao = (request()->getParsedBody()['descricao'] ?? request()->getQueryParams()['descricao'] ?? null);
            $valor = (request()->getParsedBody()['valor'] ?? request()->getQueryParams()['valor'] ?? null);

            if ($id) {
                $d->setId($id);
                $d->setDescricao($descricao);
                $d->setValor($valor);
                $d->edit();
                header('Location: despesas.php');
                exit;
            }
        }

        $id = (request()->getParsedBody()['id'] ?? request()->getQueryParams()['id'] ?? null);
        $resultado = null;
        if ($id) {
            $d->setId($id);
            $resultado = $d->viewDespesa();
        }

        return ['resultado' => $resultado, 'id' => $id];
    }
}
