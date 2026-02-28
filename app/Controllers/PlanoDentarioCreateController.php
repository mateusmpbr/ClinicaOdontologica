<?php

namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\PlanoDentario;

class PlanoDentarioCreateController
{
    public function handleRequest(): array
    {
        $errors = [];
        $values = ['nome' => '', 'desconto' => ''];

        if (function_exists('has_input') && has_input('botao')) {
            if (function_exists('validate_csrf') && !validate_csrf()) {
                error_log('CSRF token validation failed in ' . __FILE__);
                $errors['csrf'] = 'invalid_token';
            }
            $values['nome'] = input('nome', '');
            $values['desconto'] = input('desconto', '');

            $p = new PlanoDentario();
            if ($p->existeNome($values['nome'])) {
                $errors['nome'] = 'duplicate';
            } else {
                $p->setNome($values['nome']);
                $p->setDesconto($values['desconto']);
                $p->insert();
                header('Location: PlanoDentario.php');
                exit;
            }
        }

        return ['errors' => $errors, 'values' => $values];
    }
}
