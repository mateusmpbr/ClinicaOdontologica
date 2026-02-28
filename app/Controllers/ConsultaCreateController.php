<?php

namespace ClinicaOdontologica\Controllers;

use ClinicaOdontologica\Models\DentistaConsultaPaciente;
use ClinicaOdontologica\Models\Dentista;
use ClinicaOdontologica\Models\Paciente;
use ClinicaOdontologica\Models\PlanoDentario;

class ConsultaCreateController
{
    public function handleRequest(): array
    {
        verificaFuncionarioLogadoCadastro();
        verificarRecepcionistaLogadoCadastro();

        $dcp = new DentistaConsultaPaciente();
        $p = new Paciente();
        $d = new Dentista();
        $pd = new PlanoDentario();

        $flag = 0;

        $values = [
            'operacao' => '',
            'nome_paciente' => '',
            'cpf_paciente' => '',
            'valor' => '',
            'data' => '',
            'horario' => '',
            'situacao' => '',
            'nome_dentista' => '',
            'cro_dentista' => '',
        ];

        if (function_exists('has_input') && has_input('botao')) {
            if (function_exists('validate_csrf') && !validate_csrf()) {
                error_log('CSRF token validation failed in ' . __FILE__);
                return ['flag' => 5, 'values' => []];
            }
            $values['nome_dentista'] = input('nome_dentista', '');
            $values['cro_dentista'] = input('cro_dentista', '');
            $values['nome_paciente'] = input('nome_paciente', '');
            $values['cpf_paciente'] = input('cpf_paciente', '');
            $values['valor'] = input('valor', '');
            $values['data'] = input('data', '');
            $values['horario'] = input('horario', '');
            $values['situacao'] = input('situacao', '');
            $values['operacao'] = input('operacao', '');

            $p->setNome($values['nome_paciente']);
            $p->setCpf($values['cpf_paciente']);

            $id_dentista = $d->existeNomeCro($values['nome_dentista'], $values['cro_dentista']);
            if (!$id_dentista) {
                $flag = 1;
            }

            $dcp->setDentistaId($id_dentista);
            $dcp->setData($values['data']);
            $dcp->setHorario($values['horario']);

            if (!$dcp->horarioValidoCadastro()) {
                $flag = 4;
            }

            if ($flag == 0) {
                $id_paciente = $p->existeNomeCpf();
                $p->setId($id_paciente);
                $paciente = $p->viewPaciente();

                $plano_dentario_id = $paciente->plano_dentario_id ?? null;
                $pd->setId($plano_dentario_id);
                $planoDentario = $pd->viewPlanoDentario();
                $valor_final = $values['valor'];
                if (!empty($planoDentario)) {
                    $valor_final = $values['valor'] - $values['valor'] * ($planoDentario->desconto / 100);
                }

                $dcp->setDentistaId($id_dentista);
                $dcp->setPacienteId($id_paciente);
                $dcp->setValor($valor_final);
                $dcp->setData($values['data']);
                $dcp->setHorario($values['horario']);
                $dcp->setSituacao($values['situacao']);
                $dcp->setOperacao($values['operacao']);
                $id = $dcp->insert();

                if ($values['situacao'] == "Pago") {
                    header("Location: RecebimentoConsultaCreate.php?id=$id");
                    exit;
                } else {
                    header("Location: Consulta.php");
                    exit;
                }
            }
        }

        return [
            'flag' => $flag,
            'values' => $values,
        ];
    }
}
