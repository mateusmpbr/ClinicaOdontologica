<?php
require_once __DIR__ . '/../app/bootstrap.php';

use ClinicaOdontologica\Controllers\PlanoDentarioEditController;

$controller = new PlanoDentarioEditController();
$data = $controller->handleRequest();

include_once __DIR__ . '/_common/Header.php';

$resultado = $data['resultado'] ?? null;
?>

  <body class="bg-dark">

    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">
          Atualização de Plano Dentário
        </div>
        <div class="card-body">
          <form action="PlanoDentarioEdit.php" method="post">
            <?= function_exists('csrf_field') ? csrf_field() : '' ?>
            <div class="form-group">
                <label>Nome</label>
                <input type="text" class="form-control" required="required" autofocus="autofocus" name="nome" value="<?= htmlspecialchars($resultado->nome) ?>">
            </div>
            <div class="form-group">
                <label>Desconto em %</label>
                <input type="number" class="form-control" required="required" name="desconto" value="<?= htmlspecialchars($resultado->desconto) ?>">
            </div>
              <input type="hidden" name="id" value="<?= htmlspecialchars($resultado->id) ?>">
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
