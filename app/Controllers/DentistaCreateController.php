<?php

namespace ClinicaOdontologica\Controllers;

use AuthRole;
use ClinicaOdontologica\Models\Dentista;

class DentistaCreateController
{
    public function handleRequest(): array
    {
        autenticar(AuthRole::RECEPTIONIST);

        $errors = [];
        $values = ['nome' => '', 'cro' => ''];

        if (function_exists('has_input') && has_input('botao')) {
            if (function_exists('validate_csrf') && !validate_csrf()) {
                error_log('CSRF token validation failed in ' . __FILE__);
                $errors['csrf'] = 'invalid_token';
            }
            $values['nome'] = input('nome', '');
            $values['cro'] = input('cro', '');

            $d = new Dentista();
            $d->setNome($values['nome']);
            $d->setCro($values['cro']);
            // aqui validações simples podem ser aplicadas
            $d->insert();
            header('Location: /views/Administrador/index.php');
            exit;
        }

        return ['errors' => $errors, 'values' => $values];
    }
}
