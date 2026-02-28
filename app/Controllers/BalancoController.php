<?php
namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Balanco;

class BalancoController
{
    public function handleRequest(): array
    {
        $b = new Balanco();

        return [
            'despesas' => $b->valorDespesas(),
            'recebimentos' => $b->valorRecebimentos(),
            'saldo' => $b->mostraSaldo(),
        ];
    }
}
