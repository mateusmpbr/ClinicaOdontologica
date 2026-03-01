<?php
namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Paciente;
use ClinicaOdontologica\Models\Recebimento;
use ClinicaOdontologica\Models\DentistaConsultaPaciente;

class RecebimentoConsultaEditController
{
    public function handleRequest(): array
    {
        $errors = [];

        $paciente = new Paciente();
        $recebimento = new Recebimento();
        $dcp = new DentistaConsultaPaciente();

        $values = [
            'valor' => '',
            'data' => '',
            'nome_paciente' => '',
            'cpf_paciente' => '',
            'modo_pagamento' => '',
        ];

        if (function_exists('has_input') && has_input('botao')) {
            if (function_exists('validate_csrf') && !validate_csrf()) {
                error_log('CSRF token validation failed in ' . __FILE__);
                $errors['csrf'] = 'invalid_token';
            }
            $id = (request()->getParsedBody()['id'] ?? request()->getQueryParams()['id'] ?? null);
            $values['valor'] = (request()->getParsedBody()['valor'] ?? request()->getQueryParams()['valor'] ?? null);
            $values['data'] = (request()->getParsedBody()['data'] ?? request()->getQueryParams()['data'] ?? null);
            $values['nome_paciente'] = (request()->getParsedBody()['nome_paciente'] ?? request()->getQueryParams()['nome_paciente'] ?? null);
            $values['cpf_paciente'] = (request()->getParsedBody()['cpf_paciente'] ?? request()->getQueryParams()['cpf_paciente'] ?? null);
            $values['modo_pagamento'] = (request()->getParsedBody()['modo_pagamento'] ?? request()->getQueryParams()['modo_pagamento'] ?? null);

            $id_recepcionista = $_SESSION['funcionario'] ?? null;

            $paciente->setNome($values['nome_paciente']);
            $paciente->setCpf($values['cpf_paciente']);

            $recebimento->setId($id);

            if ($paciente->semNomeCpf()) {
                $recebimento->setValor($values['valor']);
                $recebimento->setData($values['data']);
                $recebimento->setRecepcionistaId($id_recepcionista);
                $recebimento->setModoPagamento($values['modo_pagamento']);
                $recebimento->edit();
                header("Location: Recebimento.php");
                exit;

            } elseif (($id_paciente = $paciente->existeNomeCpf())) {
                $recebimento->setPacienteId($id_paciente);
                $recebimento->setValor($values['valor']);
                $recebimento->setData($values['data']);
                $recebimento->setRecepcionistaId($id_recepcionista);
                $recebimento->setModoPagamento($values['modo_pagamento']);
                $recebimento->edit();
                header("Location: Recebimento.php");
                exit;
            } else {
                $errors['paciente'] = 'not_found';
            }
        } else {
            $id = (request()->getParsedBody()['id'] ?? request()->getQueryParams()['id'] ?? null);
            if ($id) {
                $dcp->setId($id);
                $consulta = $dcp->viewConsulta();
                $values['valor'] = $consulta->valor;
                $values['data'] = $consulta->data;

                $paciente_id = $consulta->paciente_id;
                $paciente->setId($paciente_id);
                $p = $paciente->viewPaciente();
                $values['nome_paciente'] = $p->nome;
                $values['cpf_paciente'] = $p->cpf;
            }
        }

        return ['errors' => $errors, 'values' => $values, 'id' => $id ?? null];
    }
}
