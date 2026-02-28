<?php

namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Especialidade;

class EspecialidadeCreateController
{
    public function handleRequest(): array
    {
        $flag = 0;
        $values = ['nome' => ''];

        if (function_exists('has_input') && has_input('botao')) {
            $values['nome'] = input('nome', '');
            $e = new Especialidade();
            $e->setNome($values['nome']);
            if ($e->viewEspecialidade()) {
                $flag = 1;
            } else {
                $e->insert();
                header('Location: especialidades.php');
                exit;
            }
        }

        return ['flag' => $flag, 'values' => $values];
    }
}
