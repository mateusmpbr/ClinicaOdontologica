<?php

namespace ClinicaOdontologica\Controllers;

use AuthRole;
use ClinicaOdontologica\Models\Dentista;

class DentistaEditController
{
    public function handleRequest(): array
    {
        autenticar(AuthRole::RECEPTIONIST);

        $flag = 0;
        $values = [];

        if (function_exists('has_input') && has_input('botao')) {
            if (function_exists('validate_csrf') && !validate_csrf()) {
                error_log('CSRF token validation failed in ' . __FILE__);
                return ['flag' => 5, 'values' => []];
            }
            $id = input('id', null);
            $values['nome'] = input('nome', '');
            $values['cro'] = input('cro', '');

            $d = new Dentista();
            $d->setId($id);
            $d->setNome($values['nome']);
            $d->setCro($values['cro']);
            $d->edit();
            header('Location: /views/Administrador/index.php');
            exit;
        }

        $id = input('id', null);
        $d = new Dentista();
        $d->setId($id);
        $resultado = $d->viewDentista();

        return ['flag' => $flag, 'values' => $values, 'resultado' => $resultado];
    }
}
