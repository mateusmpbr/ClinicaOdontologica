<?php
namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Recebimento;
use ClinicaOdontologica\Models\Paciente;

class RecebimentoEditController
{
    public function handleRequest(): array
    {
        $recebimento = new Recebimento();
        $paciente = new Paciente();
        $flag = 0;
        $values = [];

        if (function_exists('has_input') && has_input('botao')) {
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
                header('Location: recebimentos.php');
                exit;

            } elseif (($id_paciente = $paciente->existeNomeCpf())) {
                $recebimento->setPacienteId($id_paciente);
                $recebimento->setValor($values['valor']);
                $recebimento->setData($values['data']);
                $recebimento->setRecepcionistaId($id_recepcionista);
                $recebimento->setModoPagamento($values['modo_pagamento']);
                $recebimento->edit();
                header('Location: recebimentos.php');
                exit;
            } else {
                $flag = 1;
            }
        } else {
            $id = (request()->getParsedBody()['id'] ?? request()->getQueryParams()['id'] ?? null);
            $recebimento->setId($id);
            $r = $recebimento->viewRecebimento();
            $values['valor'] = $r->valor ?? '';
            $values['data'] = $r->data ?? '';
            $values['modo_pagamento'] = $r->modo_pagamento ?? '';
            $values['nome_paciente'] = '';
            $values['cpf_paciente'] = '';

            if (!empty($r->paciente_id)) {
                $paciente->setId($r->paciente_id);
                $p = $paciente->viewPaciente();
                $values['nome_paciente'] = $p->nome ?? '';
                $values['cpf_paciente'] = $p->cpf ?? '';
            }
        }

        return ['flag' => $flag, 'values' => $values, 'id' => $id ?? null];
    }
}
