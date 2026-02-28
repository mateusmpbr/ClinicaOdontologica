<?php

namespace ClinicaOdontologica\Services;

use ClinicaOdontologica\Models\Funcionario;
use ClinicaOdontologica\Models\Auxiliar;
use ClinicaOdontologica\Models\Recepcionista;
use ClinicaOdontologica\Models\Administrador;
use ClinicaOdontologica\Models\Dentista;

class FuncionarioService
{
    public function validateCpf(string $cpf): bool
    {
        $func = new Funcionario();
        $func->setCpf($cpf);
        return $func->validaCPF($cpf);
    }

    /**
     * Create a funcionario and its role-specific record.
     * Returns the inserted funcionario id.
     */
    public function create(array $values, array $postData = []): int
    {
        $func = new Funcionario();
        $func->setNome($values['nome'] ?? '');
        $func->setSobrenome($values['sobrenome'] ?? '');
        $func->setNascimento($values['nascimento'] ?? '');
        $func->setCpf($values['cpf'] ?? '');
        $func->setSalario($values['salario'] ?? '');
        $func->setCargo($values['cargo'] ?? '');

        $lastid = $func->insert();

        $cargo = $values['cargo'] ?? '';
        switch ($cargo) {
            case 'Auxiliar':
                $aux = new Auxiliar();
                $aux->setFuncionarioId($lastid);
                $aux->insert();
                break;
            case 'Recepcionista':
                $recep = new Recepcionista();
                $recep->setFuncionarioId($lastid);
                $recep->setNomeUsuario($postData['nome_usuario'] ?? '');
                $recep->setSenha($postData['senha'] ?? '');
                $recep->insert();
                break;
            case 'Administrador':
                $adm = new Administrador();
                $adm->setFuncionarioId($lastid);
                $adm->setSenha($postData['senha'] ?? '');
                $adm->setNomeUsuario($postData['nome_usuario'] ?? '');
                $adm->insert();
                break;
            case 'Dentista':
                $dent = new Dentista();
                $dent->setFuncionarioId($lastid);
                $dent->setCro($postData['cro'] ?? '');
                $dent->insert();
                break;
        }

        return (int) $lastid;
    }

    /**
     * Update funcionario and role-specific record.
     */
    public function update(int $id, array $values, array $postData = []): void
    {
        $func = new Funcionario();
        $func->setId($id);
        $func->setCpf($values['cpf'] ?? '');
        $func->setNome($values['nome'] ?? '');
        $func->setSobrenome($values['sobrenome'] ?? '');
        $func->setNascimento($values['nascimento'] ?? '');
        $func->setSalario($values['salario'] ?? '');
        $func->setCargo($values['cargo'] ?? '');
        $func->edit();

        $cargo = $values['cargo'] ?? '';
        switch ($cargo) {
            case 'Auxiliar':
                $aux = new Auxiliar();
                $aux->setFuncionarioId($id);
                $aux->edit();
                break;
            case 'Recepcionista':
                $recep = new Recepcionista();
                $recep->setFuncionarioId($id);
                $recep->setNomeUsuario($postData['nome_usuario'] ?? '');
                $recep->setSenha($postData['senha'] ?? '');
                $recep->edit();
                break;
            case 'Administrador':
                $adm = new Administrador();
                $adm->setFuncionarioId($id);
                $adm->setSenha($postData['senha'] ?? '');
                $adm->setNomeUsuario($postData['nome_usuario'] ?? '');
                $adm->edit();
                break;
            case 'Dentista':
                $dent = new Dentista();
                $dent->setFuncionarioId($id);
                $dent->setCro($postData['cro'] ?? '');
                $dent->edit();
                break;
        }
    }

    /**
     * Retrieve role-specific view data for a given funcionario id and cargo.
     * Returns the role-specific result object or null.
     */
    public function getRoleView(int $id, string $cargo)
    {
        switch ($cargo) {
            case 'Recepcionista':
                $recep = new Recepcionista();
                $recep->setFuncionarioId($id);
                return $recep->viewRecepcionista();
            case 'Administrador':
                $adm = new Administrador();
                $adm->setFuncionarioId($id);
                return $adm->viewAdministrador();
            case 'Dentista':
                $dent = new Dentista();
                $dent->setFuncionarioId($id);
                return $dent->viewDentista();
            default:
                return null;
        }
    }

    /**
     * Retrieve the main funcionario view object by id.
     */
    public function getFuncionarioView(int $id)
    {
        $func = new Funcionario();
        $func->setId($id);
        return $func->viewFuncionario();
    }
}
