<?php
require_once __DIR__ . '/../app/bootstrap.php';

use ClinicaOdontologica\Controllers\DespesaEditController;

$controller = new DespesaEditController();
$data = $controller->handleRequest();

include_once __DIR__ . '/_common/Header.php';

$resultado = $data['resultado'] ?? null;
$id = $data['id'] ?? null;
?>

  <body class="bg-dark">

    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">
          Atualização de Despesa
        </div>
        <div class="card-body">
          <form action="DespesaEdit.php" method="post">
            <?= function_exists('csrf_field') ? csrf_field() : '' ?>
            <div class="form-group">
                <label>Nome</label>
                <input type="text" class="form-control" required="required" autofocus="autofocus" name="nome" value="<?= htmlspecialchars($resultado->nome ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Valor</label>
                <input type="number" class="form-control" required="required" name="valor" value="<?= htmlspecialchars($resultado->valor ?? '') ?>">
            </div>
            <input type="hidden" name="id" value="<?= htmlspecialchars($id ?? '') ?>">
            <input type="hidden" name="data" value="<?= htmlspecialchars($resultado->data ?? '') ?>">
            <input type="hidden" name="tipo" value="<?= htmlspecialchars($resultado->tipo ?? '') ?>">
            <input type="hidden" name="situacao" value="<?= htmlspecialchars($resultado->situacao ?? '') ?>">
            <input type="hidden" name="administrador_id" value="<?= htmlspecialchars($resultado->administrador_id ?? '') ?>">
            <button class="btn btn-primary btn-block" type="submit" name="botao">Atualizar</button>
          </form>
        </div>
      </div>
    </div>

    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>
  </body>
</html>
