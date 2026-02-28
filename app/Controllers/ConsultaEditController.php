<?php

namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\DentistaConsultaPaciente;
use ClinicaOdontologica\Models\Paciente;
use ClinicaOdontologica\Models\Dentista;
use ClinicaOdontologica\Models\Funcionario;

class ConsultaEditController
{
    public function handleRequest(): array
    {
        $flag = 0;

        $dcp = new DentistaConsultaPaciente();
        $p = new Paciente();
        $d = new Dentista();
        $f = new Funcionario();

        $values = [];

        if (function_exists('has_input') && has_input('botao')) {
            $id = input('id', null);
            $paciente_id = input('paciente_id', null);
            $dentista_id = input('dentista_id', null);
            $nome_dentista = input('nome_dentista', null);
            $cro_dentista = input('cro_dentista', null);
            $nome_paciente = input('nome_paciente', null);
            $cpf_paciente = input('cpf_paciente', null);
            $valor = input('valor', null);
            $data = input('data', null);
            $horario = input('horario', null);
            $situacao = input('situacao', null);
            $situacao_antiga = input('situacao_antiga', null);
            $operacao = input('operacao', null);

            if (!$p->validaCPF($cpf_paciente)) {
                $flag = 1;
            }

            $dcp->setId($id);
            $dcp->setDentistaId($dentista_id);
            $dcp->setData($data);
            $dcp->setHorario($horario);

            if (!$dcp->horarioValido()) {
                $flag = 2;
            }

            if (!$d->existeNomeCro($nome_dentista, $cro_dentista)) {
                $flag = 3;
            }

            $p->setNome($nome_paciente);
            $p->setCpf($cpf_paciente);

            if (!$p->existeNomeCpf()) {
                $flag = 4;
            }

            if ($flag == 0) {
                $dcp->setPacienteId($paciente_id);
                $dcp->setValor($valor);
                $dcp->setSituacao($situacao);
                $dcp->setOperacao($operacao);
                $id = $dcp->edit();
                if ($situacao_antiga == "Pago") {
                    header("Location: editar-recebimentos-consultas.php?id=$id");
                    exit;
                } else {
                    if ($situacao == "Pago") {
                        header("Location: cadastrar-recebimentos-consultas.php?id=$id");
                        exit;
                    } else {
                        header("Location: consultas.php");
                        exit;
                    }
                }
            }

            $values = compact('id','paciente_id','dentista_id','nome_dentista','cro_dentista','nome_paciente','cpf_paciente','valor','data','horario','situacao','operacao');
        } else {
            $id = input('id', null);
            $dcp->setId($id);
            $consulta = $dcp->viewConsulta();
            $valor = $consulta->valor;
            $data = $consulta->data;
            $horario = $consulta->horario;
            $situacao = $consulta->situacao;
            $operacao = $consulta->operacao;

            $dentista_id = $consulta->dentista_id;
            $d->setFuncionarioId($dentista_id);
            $dentista = $d->viewDentista();
            $cro_dentista = $dentista->cro;

            $paciente_id = $consulta->paciente_id;
            $p->setId($paciente_id);
            $paciente = $p->viewPaciente();
            $nome_paciente = $paciente->nome;
            $cpf_paciente = $paciente->cpf;

            $f->setId($dentista_id);
            $funcionario = $f->viewFuncionario();
            $nome_dentista = $funcionario->nome;

            $values = compact('id','paciente_id','dentista_id','nome_dentista','cro_dentista','nome_paciente','cpf_paciente','valor','data','horario','situacao','operacao');
        }

        return [
            'flag' => $flag,
            'values' => $values,
        ];
    }
}
