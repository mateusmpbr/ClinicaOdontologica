<?php
require_once __DIR__ . '/../../app/bootstrap.php';

use ClinicaOdontologica\Controllers\EspecialidadeEditController;

$controller = new EspecialidadeEditController();
$data = $controller->handleRequest();

include_once __DIR__ . '/../_partials/header.php';

$resultado = $data['resultado'] ?? null;
?>

  <body class="bg-dark">

    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">
          Atualização de Especialidade
        </div>
        <div class="card-body">
          <form action="editar-especialidade.php" method="post">
            <div class="form-group">
              <label>Nome</label>
              <input type="text" class="form-control" required="required" autofocus="autofocus" name="nome" value="<?= htmlspecialchars($resultado->nome) ?>">
            </div>
            <input type="hidden" name="id" value="<?= htmlspecialchars($resultado->id ?? '') ?>">
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
