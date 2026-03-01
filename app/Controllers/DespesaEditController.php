<?php
namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Despesa;

class DespesaEditController
{
    public function handleRequest(): array
    {
        $d = new Despesa();

        if (function_exists('has_input') && has_input('botao')) {
            if (function_exists('validate_csrf') && !validate_csrf()) {
                error_log('CSRF token validation failed in ' . __FILE__);
                $errors = ['csrf' => 'invalid_token'];
            }
            $id = (request()->getParsedBody()['id'] ?? request()->getQueryParams()['id'] ?? null);
            $nome = (request()->getParsedBody()['nome'] ?? request()->getQueryParams()['nome'] ?? null);
            $data = (request()->getParsedBody()['data'] ?? request()->getQueryParams()['data'] ?? null);
            $valor = (request()->getParsedBody()['valor'] ?? request()->getQueryParams()['valor'] ?? null);
            $tipo = (request()->getParsedBody()['tipo'] ?? request()->getQueryParams()['tipo'] ?? null);
            $situacao = (request()->getParsedBody()['situacao'] ?? request()->getQueryParams()['situacao'] ?? null);
            $administrador_id = (request()->getParsedBody()['administrador_id'] ?? request()->getQueryParams()['administrador_id'] ?? null);

            if ($id) {
                $d->setId($id);
                $d->setNome($nome);
                $d->setData($data);
                $d->setValor($valor);
                $d->setTipo($tipo);
                $d->setSituacao($situacao);
                $d->setAdministradorId($administrador_id);
                $d->edit();
                header('Location: Despesa.php');
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
