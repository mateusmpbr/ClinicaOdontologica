<?php
namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Despesa;
use ClinicaOdontologica\Models\Balanco;

class DespesaCreateController
{
    public function handleRequest(): array
    {
        $errors = [];
        $values = [
            'nome' => '',
            'data' => '',
            'valor' => '',
            'tipo' => 'Despesa geral',
            'situacao' => 'Pago',
        ];

        if (function_exists('has_input') && has_input('botao')) {
            if (function_exists('validate_csrf') && !validate_csrf()) {
                error_log('CSRF token validation failed in ' . __FILE__);
                $errors['csrf'] = 'invalid_token';
            }
            $b = new Balanco();
            $d = new Despesa();

            $values['nome'] = (request()->getParsedBody()['nome'] ?? request()->getQueryParams()['nome'] ?? null);
            $values['data'] = (request()->getParsedBody()['data'] ?? request()->getQueryParams()['data'] ?? null);
            $values['valor'] = (request()->getParsedBody()['valor'] ?? request()->getQueryParams()['valor'] ?? null);
            $values['tipo'] = (request()->getParsedBody()['tipo'] ?? request()->getQueryParams()['tipo'] ?? null);
            $values['situacao'] = (request()->getParsedBody()['situacao'] ?? request()->getQueryParams()['situacao'] ?? null);
            $administrador_id = $_SESSION['funcionario'] ?? null;

            if ($values['situacao'] === 'Pago' && $b->mostraSaldo() - $values['valor'] < 0) {
                $errors['saldo'] = 'insufficient';
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

        return ['errors' => $errors, 'values' => $values];
    }
}
