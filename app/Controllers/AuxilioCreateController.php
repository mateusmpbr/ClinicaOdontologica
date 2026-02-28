<?php
namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Dentista;
use ClinicaOdontologica\Models\Auxiliar;
use ClinicaOdontologica\Models\AuxiliarAuxiliaDentista;

class AuxilioCreateController
{
    public function handleRequest(): array
    {
        $errors = [];
        $values = ['nome_dentista' => '', 'cro_dentista' => '', 'nome_auxiliar' => '', 'cpf_auxiliar' => ''];

        if (function_exists('has_input') && has_input('botao')) {
            if (function_exists('validate_csrf') && !validate_csrf()) {
                error_log('CSRF token validation failed in ' . __FILE__);
                $errors['csrf'] = 'invalid_token';
            }
            $d = new Dentista();
            $a = new Auxiliar();
            $aad = new AuxiliarAuxiliaDentista();

            $values['nome_dentista'] = (request()->getParsedBody()['nome_dentista'] ?? request()->getQueryParams()['nome_dentista'] ?? null);
            $values['cro_dentista'] = (request()->getParsedBody()['cro_dentista'] ?? request()->getQueryParams()['cro_dentista'] ?? null);
            $values['nome_auxiliar'] = (request()->getParsedBody()['nome_auxiliar'] ?? request()->getQueryParams()['nome_auxiliar'] ?? null);
            $values['cpf_auxiliar'] = (request()->getParsedBody()['cpf_auxiliar'] ?? request()->getQueryParams()['cpf_auxiliar'] ?? null);

            $id_dentista = $d->existeNomeCro($values['nome_dentista'], $values['cro_dentista']);
            $id_auxiliar = $a->existeNomeCpf($values['nome_auxiliar'], $values['cpf_auxiliar']);

            if (!$id_dentista) {
                $errors['dentista'] = 'not_found';
            }
            if (!$id_auxiliar) {
                $errors['auxiliar'] = 'not_found';
            }

            if (empty($errors)) {
                $aad->setDentistaId($id_dentista);
                $aad->setAuxiliarId($id_auxiliar);
                $aad->insert();
                header('Location: auxilios.php');
                exit;
            }
        }
        return ['errors' => $errors, 'values' => $values];
    }
}
