<?php

namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Especialidade;

class EspecialidadeCreateController
{
    public function handleRequest(): array
    {
        $errors = [];
        $values = ['nome' => ''];

        if (function_exists('has_input') && has_input('botao')) {
            if (function_exists('validate_csrf') && !validate_csrf()) {
                error_log('CSRF token validation failed in ' . __FILE__);
                $errors['csrf'] = 'invalid_token';
            }
            $values['nome'] = input('nome', '');
            $e = new Especialidade();
            $e->setNome($values['nome']);
            if ($e->viewEspecialidade()) {
                $errors['nome'] = 'duplicate';
            } else {
                $e->insert();
                header('Location: Especialidade.php');
                exit;
            }
        }

        return ['errors' => $errors, 'values' => $values];
    }
}
