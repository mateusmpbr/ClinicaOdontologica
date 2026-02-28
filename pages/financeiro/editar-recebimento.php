<?php
require_once __DIR__ . '/../../app/bootstrap.php';

use ClinicaOdontologica\Controllers\RecebimentoEditController;

$controller = new RecebimentoEditController();
$data = $controller->handleRequest();

include_once __DIR__ . '/../_partials/header.php';

$flag = $data['flag'] ?? 0;
$values = $data['values'] ?? [];
$id = $data['id'] ?? null;
?>
  <body class="bg-dark">

    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">
          Atualização de Recebimento
            <div class="float-right">
                <a href="paciente-recebimento.php" target="_blank" class="btn">Buscar pacientes</a>
            </div>
        </div>
        <div class="card-body">
        <?php if (!empty($flag) && $flag == 1) { ?>
          <div class="alert alert-danger form-group" role="alert">
            <b>Não há esse paciente cadastrado</b>
          </div>
        <?php } ?>
          <form action="editar-recebimento.php" method="post">
            <div class="form-group">
                <label>Nome do Paciente</label>
                <input type="text" class="form-control" name="nome_paciente" value="<?= htmlspecialchars($values['nome_paciente'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>CPF do Paciente (somente números)</label>
                <input type="text" class="form-control" maxlength="11" name="cpf_paciente" value="<?= htmlspecialchars($values['cpf_paciente'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Valor</label>
                <input type="number" class="form-control"  step="0.01" required="required" autofocus="autofocus" name="valor" value="<?= htmlspecialchars($values['valor'] ?? '') ?>">
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
                <input type="date" class="form-control" required="required" name="data" value="<?= htmlspecialchars($values['data'] ?? '') ?>">
            </div>
            <input type="hidden" name="id" value="<?= htmlspecialchars($id ?? '') ?>">
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
