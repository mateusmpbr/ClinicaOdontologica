<?php

namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Especialidade;

class EspecialidadeController
{
    public function handleRequest(): array
    {
        $e = new Especialidade();
        $stmt = $e->viewAll();
        $especialidades = $stmt->fetchAll(\PDO::FETCH_OBJ);

        // handle delete
        if (function_exists('has_input') && has_input('botao-remover')) {
            $nome = input('nome', null);
            if ($nome) {
                $e->setNome($nome);
                $e->delete();
            }
        }

        return ['especialidades' => $especialidades];
    }
}
