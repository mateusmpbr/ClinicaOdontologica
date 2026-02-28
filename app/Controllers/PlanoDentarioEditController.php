<?php

namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\PlanoDentario;

class PlanoDentarioEditController
{
    public function handleRequest(): array
    {
        $flag = 0;
        $values = [];

        if (function_exists('has_input') && has_input('botao')) {
            $id = input('id', null);
            $nome = input('nome', '');
            $desconto = input('desconto', '');

            $p = new PlanoDentario();
            $p->setId($id);
            $p->setNome($nome);
            $p->setDesconto($desconto);
            $p->edit();
            header('Location: planos-dentarios.php');
            exit;
        }

        $id = input('id', null);
        $p = new PlanoDentario();
        $p->setId($id);
        $resultado = $p->viewPlanoDentario();

        return ['flag' => $flag, 'resultado' => $resultado];
    }
}
