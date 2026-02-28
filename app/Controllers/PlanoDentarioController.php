<?php

namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\PlanoDentario;

class PlanoDentarioController
{
    public function handleRequest(): array
    {
        $p = new PlanoDentario();

        if (function_exists('has_input') && has_input('botao-remover')) {
            $id = input('id', null);
            if ($id) {
                $p->setId($id);
                $p->delete();
            }
        }

        $stmt = $p->viewAll();
        $planos = $stmt->fetchAll(\PDO::FETCH_OBJ);

        return ['planos' => $planos];
    }
}
