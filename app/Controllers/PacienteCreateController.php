<?php

namespace ClinicaOdontologica\Controllers;

use AuthRole;
use ClinicaOdontologica\Models\Paciente;
use ClinicaOdontologica\Models\PlanoDentario;

class PacienteCreateController
{
    public function handleRequest(): array
    {
        autenticar(AuthRole::RECEPTIONIST);
        $values = [
            'nome' => '',
            'sobrenome' => '',
            'nascimento' => '',
            'cpf' => '',
            'plano_dentario' => '',
        ];
        $errors = [];

        if (function_exists('has_input') && has_input('botao')) {
            if (function_exists('validate_csrf') && !validate_csrf()) {
                error_log('CSRF token validation failed in ' . __FILE__);
                $errors['csrf'] = 'invalid_token';
                // continue to render form with error
            }
            $values['nome'] = input('nome', '');
            $values['sobrenome'] = input('sobrenome', '');
            $values['nascimento'] = input('nascimento', '');
            $values['cpf'] = input('cpf', '');
            $values['plano_dentario'] = input('plano_dentario', '');

            $paciente = new Paciente();
            $paciente->setNome($values['nome']);
            $paciente->setSobrenome($values['sobrenome']);
            $paciente->setNascimento($values['nascimento']);
            $paciente->setCpf($values['cpf']);
            $paciente->setPlanoDentarioId($values['plano_dentario']);

            if (!$paciente->validaCPF($values['cpf'])) {
                $errors['cpf'] = 'invalid';
            }
            if ($paciente->existeCpf()) {
                $errors['cpf'] = 'duplicate';
            }

            if (empty($errors)) {
                $paciente->insert();
                header('Location: /views/Recepcionista/index.php');
                exit;
            }
        }

        $planoDentario = new PlanoDentario();
        $stmt = $planoDentario->viewAll();
        $planos = $stmt->fetchAll(\PDO::FETCH_OBJ);

        return [
            'errors' => $errors,
            'values' => $values,
            'planos' => $planos,
        ];
    }
}
