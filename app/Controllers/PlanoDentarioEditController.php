<?php

namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\PlanoDentario;

class PlanoDentarioEditController
{
    public function handleRequest(): array
    {
        $errors = [];
        $values = [];

        if (function_exists('has_input') && has_input('botao')) {
            if (function_exists('validate_csrf') && !validate_csrf()) {
                error_log('CSRF token validation failed in ' . __FILE__);
                $errors['csrf'] = 'invalid_token';
            }
            $id = input('id', null);
            $nome = input('nome', '');
            $desconto = input('desconto', '');

            $p = new PlanoDentario();
            $p->setId($id);
            $p->setNome($nome);
            $p->setDesconto($desconto);
            $p->edit();
            header('Location: PlanoDentario.php');
            exit;
        }

        $id = input('id', null);
        $p = new PlanoDentario();
        $p->setId($id);
        $resultado = $p->viewPlanoDentario();

        return ['errors' => $errors, 'resultado' => $resultado];
    }
}
