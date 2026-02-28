<?php
namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\Dentista;
use ClinicaOdontologica\Models\Auxiliar;
use ClinicaOdontologica\Models\Funcionario;
use ClinicaOdontologica\Models\AuxiliarAuxiliaDentista;

class AuxilioEditController
{
    public function handleRequest(): array
    {
        $errors = [];
        $values = [];

        $d = new Dentista();
        $a = new Auxiliar();
        $f = new Funcionario();
        $aad = new AuxiliarAuxiliaDentista();

        if (function_exists('has_input') && has_input('botao')) {
            if (function_exists('validate_csrf') && !validate_csrf()) {
                error_log('CSRF token validation failed in ' . __FILE__);
                $errors['csrf'] = 'invalid_token';
            }
            $dentista_id_atual = (request()->getParsedBody()['dentista_id_atual'] ?? request()->getQueryParams()['dentista_id_atual'] ?? null);
            $auxiliar_id_atual = (request()->getParsedBody()['auxiliar_id_atual'] ?? request()->getQueryParams()['auxiliar_id_atual'] ?? null);
            $values['nome_dentista'] = (request()->getParsedBody()['nome_dentista'] ?? request()->getQueryParams()['nome_dentista'] ?? null);
            $values['cro_dentista'] = (request()->getParsedBody()['cro_dentista'] ?? request()->getQueryParams()['cro_dentista'] ?? null);
            $values['nome_auxiliar'] = (request()->getParsedBody()['nome_auxiliar'] ?? request()->getQueryParams()['nome_auxiliar'] ?? null);
            $values['cpf_auxiliar'] = (request()->getParsedBody()['cpf_auxiliar'] ?? request()->getQueryParams()['cpf_auxiliar'] ?? null);

            $auxiliar_id_novo = $a->existeNomeCpf($values['nome_auxiliar'], $values['cpf_auxiliar']);
            $dentista_id_novo = $d->existeNomeCro($values['nome_dentista'], $values['cro_dentista']);

            if (empty($dentista_id_novo)) {
                $errors['dentista'] = 'not_found';
            }
            if (empty($auxiliar_id_novo)) {
                $errors['auxiliar'] = 'not_found';
            }

            if (empty($errors)) {
                $aad->setDentistaId($dentista_id_atual);
                $aad->setAuxiliarId($auxiliar_id_atual);
                $aad->edit($dentista_id_novo, $auxiliar_id_novo);
                header('Location: auxilios.php');
                exit;
            }

            $dentista_id = $dentista_id_novo;
            $auxiliar_id = $auxiliar_id_novo;

        } else {
            $dentista_id = (request()->getParsedBody()['dentista_id'] ?? request()->getQueryParams()['dentista_id'] ?? null);
            $auxiliar_id = (request()->getParsedBody()['auxiliar_id'] ?? request()->getQueryParams()['auxiliar_id'] ?? null);

            $aad->setDentistaId($dentista_id);
            $aad->setAuxiliarId($auxiliar_id);

            $d->setFuncionarioId($dentista_id);
            $dentista = $d->viewDentista();
            $values['cro_dentista'] = $dentista->cro ?? '';

            $f->setId($dentista_id);
            $funcionario = $f->viewFuncionario();
            $values['nome_dentista'] = $funcionario->nome ?? '';

            $f->setId($auxiliar_id);
            $funcionario = $f->viewFuncionario();
            $values['cpf_auxiliar'] = $funcionario->cpf ?? '';
            $values['nome_auxiliar'] = $funcionario->nome ?? '';
        }

        return ['errors' => $errors, 'values' => $values, 'dentista_id' => $dentista_id ?? null, 'auxiliar_id' => $auxiliar_id ?? null];
    }
}
