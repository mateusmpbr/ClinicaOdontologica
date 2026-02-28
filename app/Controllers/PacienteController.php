<?php

namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Paciente;

class PacienteController
{
    public function handleRequest(): array
    {
        $p = new Paciente();
        $stmt = $p->viewAll();
        $pacientes = $stmt->fetchAll(\PDO::FETCH_OBJ);

        return ['pacientes' => $pacientes];
    }
}
