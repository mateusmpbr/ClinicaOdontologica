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
            $values['nome'] = input('nome', '');
            $values['desconto'] = input('desconto', '');

            $p = new PlanoDentario();
            if ($p->existeNome($values['nome'])) {
                $flag = 1;
            } else {
                $p->setNome($values['nome']);
                $p->setDesconto($values['desconto']);
                $p->insert();
                header('Location: planos-dentarios.php');
                exit;
            }
        }

        return ['flag' => $flag, 'values' => $values];
    }
}
