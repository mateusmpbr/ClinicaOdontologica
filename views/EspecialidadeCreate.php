<?php
require_once __DIR__ . '/../app/bootstrap.php';

use ClinicaOdontologica\Controllers\EspecialidadeCreateController;

$controller = new EspecialidadeCreateController();
$data = $controller->handleRequest();

include_once __DIR__ . '/_common/Header.php';

$nome = $data['values']['nome'] ?? '';
$flag = $data['flag'] ?? 0;
?>
<body class="bg-dark">
  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Cadastro de Especialidade</div>
      <div class="card-body">
        <?php if ($flag == 1) { ?>
          <div class="alert alert-danger form-group" role="alert">
            <b>Especialidade já cadastrada</b>
          </div>
        <?php } ?>
        <form action="EspecialidadeCreate.php" method="post">
          <?= function_exists('csrf_field') ? csrf_field() : '' ?>
          <?= function_exists('csrf_field') ? csrf_field() : '' ?>
          <div class="form-group">
            <label>Nome</label>
            <input class="form-control" name="nome" required value="<?= htmlspecialchars($nome) ?>">
          </div>
          <button class="btn btn-primary btn-block" type="submit" name="botao">Cadastrar</button>
        </form>
      </div>
    </div>
  </div>

  <script src="/vendor/jquery/jquery.min.js"></script>
  <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>
</body>
</html>
