<?php
require_once __DIR__ . '/../../app/bootstrap.php';

use ClinicaOdontologica\Controllers\RecebimentoConsultaEditController;

$controller = new RecebimentoConsultaEditController();
$data = $controller->handleRequest();

include_once __DIR__ . '/../_partials/header.php';
?>
  <body class="bg-dark">

    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">
          Atualização de Recebimento
            <div class="float-right">
                <a href="paciente-consulta.php" target="_blank" class="btn">Buscar pacientes</a>
            </div>
        </div>
        <div class="card-body">
        <?php if ($flag == 1) { ?>
          <div class="alert alert-danger form-group" role="alert">
            <b>O nome e o CPF informado não estão cadastrados ou não coincidem</b>
          </div>
        <?php } ?>
            <form action="editar-recebimentos-consultas.php" method="post">
            <div class="form-group">
              <label>Nome do Paciente</label>
              <input type="text" class="form-control" name="nome_paciente" value="<?= htmlspecialchars($data['values']['nome_paciente'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label>CPF do Paciente (somente números)</label>
              <input type="text" class="form-control" maxlength="11" name="cpf_paciente" value="<?= htmlspecialchars($data['values']['cpf_paciente'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label>Valor</label>
              <input type="number" class="form-control" required="required" autofocus="autofocus" name="valor" value="<?= htmlspecialchars($data['values']['valor'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label>Modo de Pagamento</label><br>
              <select name="modo_pagamento">
                <option value="Cartão de Crédito">Cartão de Crédito</option>
                <option value="Cartão de Débito">Cartão de Débito</option>
                <option value="Espécie">Espécie</option>
              </select>
            </div>
            <div class="form-group">
              <label>Data</label>
              <input type="date" class="form-control" required="required" name="data" value="<?= htmlspecialchars($data['values']['data'] ?? '') ?>">
            </div>
            <input type="hidden" name="id" value="<?= htmlspecialchars($data['id'] ?? '') ?>">
            <button class="btn btn-primary btn-block" type="submit" name="botao">Atualizar</button>
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
