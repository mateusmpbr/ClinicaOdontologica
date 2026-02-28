<?php

namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Dentista;

class DentistaController
{
    public function handleRequest(): array
    {
        $d = new Dentista();
        $stmt = $d->viewAll();
        $dentistas = $stmt->fetchAll(\PDO::FETCH_OBJ);

        return ['dentistas' => $dentistas];
    }
}
