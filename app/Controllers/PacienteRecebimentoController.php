<?php
namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Paciente;

class PacienteRecebimentoController
{
    public function handleRequest(): array
    {
        $p = new Paciente();
        $stmt = $p->viewAll();

        $rows = [];
        while ($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
            $rows[] = $row;
        }

        return ['rows' => $rows];
    }
}
