<?php
namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Despesa;
use ClinicaOdontologica\Models\Balanco;

class DespesaCreateController
{
    public function handleRequest(): array
    {
        $flag = 0;
        $values = [
            'nome' => '',
            'data' => '',
            'valor' => '',
            'tipo' => 'Despesa geral',
            'situacao' => 'Pago',
        ];

        if (function_exists('has_input') && has_input('botao')) {
            $b = new Balanco();
            $d = new Despesa();

            $values['nome'] = (request()->getParsedBody()['nome'] ?? request()->getQueryParams()['nome'] ?? null);
            $values['data'] = (request()->getParsedBody()['data'] ?? request()->getQueryParams()['data'] ?? null);
            $values['valor'] = (request()->getParsedBody()['valor'] ?? request()->getQueryParams()['valor'] ?? null);
            $values['tipo'] = (request()->getParsedBody()['tipo'] ?? request()->getQueryParams()['tipo'] ?? null);
            $values['situacao'] = (request()->getParsedBody()['situacao'] ?? request()->getQueryParams()['situacao'] ?? null);
            $administrador_id = $_SESSION['funcionario'] ?? null;

            if ($values['situacao'] === 'Pago' && $b->mostraSaldo() - $values['valor'] < 0) {
                $flag = 1;
            } else {
                $d->setNome($values['nome']);
                $d->setData($values['data']);
                $d->setValor($values['valor']);
                $d->setTipo($values['tipo']);
                $d->setSituacao($values['situacao']);
                $d->setAdministradorId($administrador_id);
                $d->insert();
                header('Location: despesas.php');
                exit;
            }
        }

        return ['flag' => $flag, 'values' => $values];
    }
}
