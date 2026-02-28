<?php

namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Auxiliar;

class AuxiliarController
{
    public function handleRequest(): array
    {
        $a = new Auxiliar();
        $stmt = $a->viewAll();
        $auxiliares = $stmt->fetchAll(\PDO::FETCH_OBJ);
        return ['auxiliares' => $auxiliares];
    }
}
