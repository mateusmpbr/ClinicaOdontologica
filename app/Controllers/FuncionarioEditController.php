<?php

namespace ClinicaOdontologica\Controllers;

use AuthRole;
use ClinicaOdontologica\Services\FuncionarioService;

class FuncionarioEditController
{
    public function handleRequest(): array
    {
        autenticar(AuthRole::RECEPTIONIST);

        $errors = [];
        $step = 0;
        $values = [];
        $service = new FuncionarioService();

        if (function_exists('has_input') && has_input('botao')) {
            if (function_exists('validate_csrf') && !validate_csrf()) {
                error_log('CSRF token validation failed in ' . __FILE__);
                $errors['csrf'] = 'invalid_token';
            }
            $id = input('id', null);
            $values['id'] = $id;
            $values['nome'] = input('nome', '');
            $values['sobrenome'] = input('sobrenome', '');
            $values['nascimento'] = input('nascimento', '');
            $values['cpf'] = input('cpf', '');
            $values['salario'] = input('salario', '');
            $values['cargo'] = input('cargo', '');

            if (!$service->validateCpf($values['cpf'])) {
                $errors['cpf'] = 'invalid';
                $step = 0;
            } else {
                $step = 2;
                $resultado = $service->getRoleView((int)$id, $values['cargo']);
            }
        } elseif (function_exists('has_input') && has_input('botao-detalhe')) {
            $id = input('id', null);
            $values['id'] = $id;
            $values['nome'] = input('nome', '');
            $values['sobrenome'] = input('sobrenome', '');
            $values['nascimento'] = input('nascimento', '');
            $values['cpf'] = input('cpf', '');
            $values['salario'] = input('salario', '');
            $values['cargo'] = input('cargo', '');

            $service->update((int)$id, $values, [
                'nome_usuario' => input('nome_usuario', ''),
                'senha' => input('senha', ''),
                'cro' => input('cro', ''),
            ]);

            header('Location: /views/Administrador/index.php');
            exit;
        } else {
            $id = input('id', null);
            $service = new FuncionarioService();
            $resultado = $service->getFuncionarioView((int)$id);
            $values['cargo'] = $resultado->cargo ?? '';
        }

        return ['errors' => $errors, 'step' => $step, 'values' => $values, 'resultado' => $resultado ?? null];
    }
}
