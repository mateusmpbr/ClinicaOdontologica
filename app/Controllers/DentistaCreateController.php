<?php

namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Dentista;

class DentistaCreateController
{
    public function handleRequest(): array
    {
        verificaFuncionarioLogadoCadastro();
        verificarRecepcionistaLogadoCadastro();

        $flag = 0;
        $values = ['nome' => '', 'cro' => ''];

        if (function_exists('has_input') && has_input('botao')) {
            if (function_exists('validate_csrf') && !validate_csrf()) {
                error_log('CSRF token validation failed in ' . __FILE__);
                return ['flag' => 5, 'values' => []];
            }
            $values['nome'] = input('nome', '');
            $values['cro'] = input('cro', '');

            $d = new Dentista();
            $d->setNome($values['nome']);
            $d->setCro($values['cro']);
            // aqui validações simples podem ser aplicadas
            $d->insert();
            header('Location: index.php');
            exit;
        }

        return ['flag' => $flag, 'values' => $values];
    }
}
