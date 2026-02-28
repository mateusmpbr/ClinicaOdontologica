<?php

namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\PlanoDentario;

class PlanoDentarioCreateController
{
    public function handleRequest(): array
    {
        $flag = 0;
        $values = ['nome' => '', 'desconto' => ''];

        if (function_exists('has_input') && has_input('botao')) {
            if (function_exists('validate_csrf') && !validate_csrf()) {
                error_log('CSRF token validation failed in ' . __FILE__);
                return ['flag' => 5, 'values' => []];
            }
            $values['nome'] = input('nome', '');
            $values['desconto'] = input('desconto', '');

            $p = new PlanoDentario();
            if ($p->existeNome($values['nome'])) {
                $flag = 1;
            } else {
                $p->setNome($values['nome']);
                $p->setDesconto($values['desconto']);
                $p->insert();
                header('Location: PlanoDentario.php');
                exit;
            }
        }

        return ['flag' => $flag, 'values' => $values];
    }
}
