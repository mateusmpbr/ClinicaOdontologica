<?php
require_once __DIR__ . '/../../app/bootstrap.php';

use ClinicaOdontologica\Controllers\ConsultaCreateController;

$controller = new ConsultaCreateController();
$data = $controller->handleRequest();

include_once __DIR__ . '/../_partials/header.php';
?>
  <body class="bg-dark">
    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">
          Cadastro de Consulta
          <div class="float-right">
            <a href="paciente-consulta.php" target="_blank" class="btn">Buscar pacientes</a>
            <a href="dentista-consulta.php" target="_blank" class="btn">Buscar dentistas</a>
          </div>
        </div>
        <div class="card-body">
        <?php
        if ($data['flag'] == 1) { ?>
          <div class="alert alert-danger form-group" role="alert">
            <b>O nome e o CRO do dentista não estão cadastrados ou não coincidem</b>
          </div>
        <?php } elseif ($data['flag'] == 2) { ?>
          <div class="alert alert-danger form-group" role="alert">
            <b>O nome e o CPF do paciente não estão cadastrados ou não coincidem</b>
          </div>
        <?php } elseif ($data['flag'] == 3) { ?>
          <div class="alert alert-danger form-group" role="alert">
            <b>Os dados informados não estão cadastrados ou não coincidem</b>
          </div>
        <?php } elseif ($data['flag'] == 4) { ?>
          <div class="alert alert-danger form-group" role="alert">
            <b>Já há uma pessoa agendada</b>
          </div>
        <?php }  ?>
          <form action="cadastrar-consulta.php" method="post">
            <div class="form-group">
                <label>Operação</label>
                <input type="text" class="form-control" required="required" autofocus="autofocus" name="operacao" value="<?= htmlspecialchars($data['values']['operacao']) ?>">
            </div>
            <div class="form-group">
                <label>Nome do Paciente</label>
                <input type="text" class="form-control" name="nome_paciente" value="<?= htmlspecialchars($data['values']['nome_paciente']) ?>">
            </div>
            <div class="form-group">
                <label>CPF do Paciente (somente números)</label>
                <input type="text" class="form-control" maxlength="11" name="cpf_paciente" value="<?= htmlspecialchars($data['values']['cpf_paciente']) ?>">
            </div>
            <div class="form-group">
                <label>Nome do Dentista</label>
                <input type="text" class="form-control" required="required" name="nome_dentista" value="<?= htmlspecialchars($data['values']['nome_dentista']) ?>">
            </div>
            <div class="form-group">
                <label>CRO do Dentista</label>
                <input type="text" class="form-control" maxlength="5" name="cro_dentista" value="<?= htmlspecialchars($data['values']['cro_dentista']) ?>">
            </div>
            <div class="form-group">
                <label>Data</label>
                <input type="date" class="form-control" required="required" name="data" value="<?= htmlspecialchars($data['values']['data']) ?>">
            </div>
            <div class="form-group">
                <label>Horário</label>
                <input type="time" class="form-control" required="required" autofocus="autofocus" name="horario" value="<?= htmlspecialchars($data['values']['horario']) ?>">
            </div>
            <div class="form-group">
                <label>Valor</label>
                <input type="number"  step="0.01" class="form-control" required="required" autofocus="autofocus" name="valor" value="<?= htmlspecialchars($data['values']['valor']) ?>">
            </div>
            <div class="form-group">
                <label>Situação</label><br>
                <select name="situacao">
                    <option value="Pago" <?=($data['values']['situacao']==='Pago')?"selected":""?>>Pago</option>
                    <option value="Não Pago" <?=($data['values']['situacao']==='Não Pago')?"selected":""?>>Não Pago</option>
                </select>
            </div>
            <button class="btn btn-primary btn-block" type="submit" name="botao">Cadastrar</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>
  </body>
</html>
