<?php

namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Paciente;
use ClinicaOdontologica\Models\PlanoDentario;

class PacienteEditController
{
    public function handleRequest(): array
    {
        verificaFuncionarioLogadoCadastro();
        verificarRecepcionistaLogadoCadastro();

        $flag = 0;
        $values = [];

        if (function_exists('has_input') && has_input('botao')) {
            $id = input('id', null);
            $values['nome'] = input('nome', '');
            $values['sobrenome'] = input('sobrenome', '');
            $values['nascimento'] = input('nascimento', '');
            $values['cpf'] = input('cpf', '');
            $values['plano_dentario'] = input('plano_dentario', '');

            $paciente = new Paciente();
            $paciente->setId($id);
            $paciente->setCpf($values['cpf']);
            $paciente->setNome($values['nome']);
            $paciente->setSobrenome($values['sobrenome']);
            $paciente->setNascimento($values['nascimento']);
            $paciente->setPlanoDentarioId($values['plano_dentario']);

            if (!$paciente->validaCPF($values['cpf'])) {
                $flag = 1;
                $resultado = $paciente->viewPaciente();
            }

            if ($paciente->existeCpf()) {
                $flag = 2;
                $resultado = $paciente->viewPaciente();
            }

            if ($flag == 0) {
                $paciente->edit();
                header('Location: index.php');
                exit;
            }

            return [
                'flag' => $flag,
                'values' => $values,
                'resultado' => $resultado ?? null,
            ];
        }

        $id = input('id', null);
        $paciente = new Paciente();
        $paciente->setId($id);
        $resultado = $paciente->viewPaciente();

        $planoDentario = new PlanoDentario();
        $stmt = $planoDentario->viewAll();
        $planos = $stmt->fetchAll(\PDO::FETCH_OBJ);

        return [
            'flag' => $flag,
            'values' => [],
            'resultado' => $resultado,
            'planos' => $planos,
        ];
    }
}
