<?php

namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Dentista;

class DentistaEditController
{
    public function handleRequest(): array
    {
        verificaFuncionarioLogadoCadastro();
        verificarRecepcionistaLogadoCadastro();

        $flag = 0;
        $values = [];

        if (function_exists('has_input') && has_input('botao')) {
            $id = input('id', null);
            $values['nome'] = input('nome', '');
            $values['cro'] = input('cro', '');

            $d = new Dentista();
            $d->setId($id);
            $d->setNome($values['nome']);
            $d->setCro($values['cro']);
            $d->edit();
            header('Location: index.php');
            exit;
        }

        $id = input('id', null);
        $d = new Dentista();
        $d->setId($id);
        $resultado = $d->viewDentista();

        return ['flag' => $flag, 'values' => $values, 'resultado' => $resultado];
    }
}
