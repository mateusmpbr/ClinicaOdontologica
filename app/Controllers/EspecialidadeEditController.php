<?php

namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Especialidade;

class EspecialidadeEditController
{
    public function handleRequest(): array
    {
        $flag = 0;
        $values = [];

        if (function_exists('has_input') && has_input('botao')) {
            $id = input('id', null);
            $nome = input('nome', '');
            $e = new Especialidade();
            $e->setId($id);
            $e->setNome($nome);
            $e->edit();
            header('Location: especialidades.php');
            exit;
        }

        $nome = input('nome', null);
        $e = new Especialidade();
        $e->setNome($nome);
        $resultado = $e->viewEspecialidade();

        return ['flag' => $flag, 'resultado' => $resultado];
    }
}
