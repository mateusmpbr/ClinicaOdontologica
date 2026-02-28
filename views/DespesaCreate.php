<?php
require_once __DIR__ . '/../app/bootstrap.php';

use ClinicaOdontologica\Controllers\DespesaCreateController;

$controller = new DespesaCreateController();
$data = $controller->handleRequest();

include_once __DIR__ . '/_common/header.php';
?>
  <body class="bg-dark">

    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">
          Cadastro de Despesa
        </div>
        <div class="card-body">
        <?php if (!empty($data['flag']) && $data['flag'] == 1) { ?>
          <div class="alert alert-danger form-group" role="alert">
            <b>Não há saldo suficiente</b>
          </div>
        <?php } ?>
          <form action="DespesaCreate.php" method="post">
            <?= function_exists('csrf_field') ? csrf_field() : '' ?>
            <?= function_exists('csrf_field') ? csrf_field() : '' ?>
            <div class="form-group">
                <label>Nome</label>
                <input type="text" class="form-control" required="required" autofocus="autofocus" name="nome" value="<?= htmlspecialchars($data['values']['nome'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Data</label>
                <input type="date" class="form-control" required="required" name="data" value="<?= htmlspecialchars($data['values']['data'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Valor</label>
                <input type="number" step="0.01" class="form-control" required="required" name="valor" value="<?= htmlspecialchars($data['values']['valor'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Tipo</label><br>
                <select name="tipo">
                    <option value="Despesa geral" <?= (isset($data['values']['tipo']) && $data['values']['tipo'] === 'Despesa geral') ? 'selected' : '' ?>>Despesa Geral</option>
                    <option value="Despesa com Funcionário" <?= (isset($data['values']['tipo']) && $data['values']['tipo'] === 'Despesa com Funcionário') ? 'selected' : '' ?>>Despesa com Funcionário</option>
                </select>
            </div>
            <div class="form-group">
                <label>Situação</label><br>
                <select name="situacao">
                    <option value="Pago" <?= (isset($data['values']['situacao']) && $data['values']['situacao'] === 'Pago') ? 'selected' : '' ?>>Pago</option>
                    <option value="Não Pago" <?= (isset($data['values']['situacao']) && $data['values']['situacao'] === 'Não Pago') ? 'selected' : '' ?>>Não Pago</option>
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
