<?php
namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Recebimento;
use ClinicaOdontologica\Models\Paciente;

class RecebimentoCreateController
{
    public function handleRequest(): array
    {
        $flag = 0;
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
                return ['flag' => 5, 'values' => []];
            }
            $paciente = new Paciente();
            $recebimento = new Recebimento();

            $values['valor'] = (request()->getParsedBody()['valor'] ?? request()->getQueryParams()['valor'] ?? null);
            $values['data'] = (request()->getParsedBody()['data'] ?? request()->getQueryParams()['data'] ?? null);
            $values['nome_paciente'] = (request()->getParsedBody()['nome_paciente'] ?? request()->getQueryParams()['nome_paciente'] ?? null);
            $values['cpf_paciente'] = (request()->getParsedBody()['cpf_paciente'] ?? request()->getQueryParams()['cpf_paciente'] ?? null);
            $values['modo_pagamento'] = (request()->getParsedBody()['modo_pagamento'] ?? request()->getQueryParams()['modo_pagamento'] ?? null);

            $id_recepcionista = $_SESSION['funcionario'] ?? null;

            $paciente->setNome($values['nome_paciente']);
            $paciente->setCpf($values['cpf_paciente']);

            if ($paciente->semNomeCpf()) {
                $recebimento->setValor($values['valor']);
                $recebimento->setData($values['data']);
                $recebimento->setRecepcionistaId($id_recepcionista);
                $recebimento->setModoPagamento($values['modo_pagamento']);
                $recebimento->insert();
                header('Location: recebimentos.php');
                exit;

            } elseif (($id_paciente = $paciente->existeNomeCpf())) {
                $recebimento->setPacienteId($id_paciente);
                $recebimento->setValor($values['valor']);
                $recebimento->setData($values['data']);
                $recebimento->setRecepcionistaId($id_recepcionista);
                $recebimento->setModoPagamento($values['modo_pagamento']);
                $recebimento->insert();
                header('Location: recebimentos.php');
                exit;
            } else {
                $flag = 1;
            }
        }

        return ['flag' => $flag, 'values' => $values];
    }
}
