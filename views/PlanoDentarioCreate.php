<?php
require_once __DIR__ . '/../app/bootstrap.php';

use ClinicaOdontologica\Controllers\PlanoDentarioCreateController;

$controller = new PlanoDentarioCreateController();
$data = $controller->handleRequest();

include_once __DIR__ . '/_common/Header.php';

$errors = $data['errors'] ?? [];
$values = $data['values'] ?? ['nome' => '', 'desconto' => ''];
?>
<body class="bg-dark">

  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">
        Cadastro de Plano Dentário
      </div>
      <div class="card-body">
        <?php if (!empty($errors['nome']) && $errors['nome'] === 'duplicate') { ?>
          <div class="alert alert-danger form-group" role="alert">
            <b>Esse plano dentário já está cadastrado</b>
          </div>
        <?php } ?>
        <form action="PlanoDentarioCreate.php" method="post">
          <?= function_exists('csrf_field') ? csrf_field() : '' ?>
          <?= function_exists('csrf_field') ? csrf_field() : '' ?>
          <div class="form-group">
              <label>Nome</label>
              <input type="text" class="form-control" required="required" autofocus="autofocus" name="nome" value="<?= htmlspecialchars($values['nome']) ?>">
          </div>
          <div class="form-group">
              <label>Desconto em %</label>
              <input type="number" class="form-control" required="required" name="desconto" value="<?= htmlspecialchars($values['desconto']) ?>">
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
