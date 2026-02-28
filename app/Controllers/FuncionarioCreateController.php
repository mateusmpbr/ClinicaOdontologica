<?php

namespace ClinicaOdontologica\Controllers;

use AuthRole;
use ClinicaOdontologica\Services\FuncionarioService;

class FuncionarioCreateController
{
    public function handleRequest(): array
    {
        autenticar(AuthRole::RECEPTIONIST);

        $errors = [];
        $step = 0; // 0 = initial, 1 = detail
        $values = [
            'nome' => '', 'sobrenome' => '', 'nascimento' => '', 'cpf' => '', 'salario' => '', 'cargo' => ''
        ];

        $service = new FuncionarioService();

        if (function_exists('has_input') && has_input('botao')) {
            if (function_exists('validate_csrf') && !validate_csrf()) {
                error_log('CSRF token validation failed in ' . __FILE__);
                $errors['csrf'] = 'invalid_token';
            }
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
                $step = 2; // proceed to detail
            }
        } elseif (function_exists('has_input') && has_input('botao-detalhe')) {
            $values['nome'] = input('nome', '');
            $values['sobrenome'] = input('sobrenome', '');
            $values['nascimento'] = input('nascimento', '');
            $values['cpf'] = input('cpf', '');
            $values['salario'] = input('salario', '');
            $values['cargo'] = input('cargo', '');

            $service->create($values, [
                'nome_usuario' => input('nome_usuario', ''),
                'senha' => input('senha', ''),
                'cro' => input('cro', ''),
            ]);
            header('Location: /views/Administrador/index.php');
            exit;
        }

        return ['errors' => $errors, 'step' => $step, 'values' => $values];
    }
}
