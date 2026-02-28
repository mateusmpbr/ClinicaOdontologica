<?php

namespace ClinicaOdontologica\Controllers;

use AuthRole;
use ClinicaOdontologica\Models\Paciente;
use ClinicaOdontologica\Models\PlanoDentario;

class PacienteEditController
{
    public function handleRequest(): array
    {
        autenticar(AuthRole::RECEPTIONIST);

        $errors = [];
        $values = [];

        if (function_exists('has_input') && has_input('botao')) {
            if (function_exists('validate_csrf') && !validate_csrf()) {
                error_log('CSRF token validation failed in ' . __FILE__);
                $errors['csrf'] = 'invalid_token';
            }
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
                $errors['cpf'] = 'invalid';
                $resultado = $paciente->viewPaciente();
            }

            if ($paciente->existeCpf()) {
                $errors['cpf'] = 'duplicate';
                $resultado = $paciente->viewPaciente();
            }

            if (empty($errors)) {
                $paciente->edit();
                header('Location: /views/Recepcionista/index.php');
                exit;
            }

            return [
                'errors' => $errors,
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
            'errors' => $errors,
            'values' => [],
            'resultado' => $resultado,
            'planos' => $planos,
        ];
    }
}
