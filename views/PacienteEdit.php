<?php
require_once __DIR__ . '/../app/bootstrap.php';

use ClinicaOdontologica\Controllers\PacienteEditController;

$controller = new PacienteEditController();
$data = $controller->handleRequest();

include_once __DIR__ . '/_partials/header.php';

// compatibility variables
$flag = $data['flag'] ?? 0;
$resultado = $data['resultado'] ?? null;
$planos = $data['planos'] ?? [];
?>
  <body class="bg-dark">

    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">
          Atualização de Paciente
        </div>
        <div class="card-body">
        <?php if ($flag == 1) { ?>
          <div class="alert alert-danger form-group" role="alert">
            <b>O CPF informado não é válido</b>
          </div>
        <?php } elseif ($flag == 2) { ?>
          <div class="alert alert-danger form-group" role="alert">
            <b>O CPF informado já foi cadastrado</b>
          </div>
        <?php } ?>
          <form action="PacienteEdit.php" method="post">
            <div class="form-group">
              <label>Primeiro nome</label>
              <input type="text" class="form-control" required="required" autofocus="autofocus" name="nome" value="<?= htmlspecialchars($resultado->nome) ?>">
            </div>
            <div class="form-group">
              <label>Sobrenome</label>
              <input type="text" class="form-control" required="required" name="sobrenome" value="<?= htmlspecialchars($resultado->sobrenome) ?>">
            </div>
            <div class="form-group">
              <label>Data de nascimento</label>
              <input type="date" class="form-control" required="required" name="nascimento" value="<?= htmlspecialchars($resultado->nascimento) ?>">
            </div>
            <div class="form-group">
                <label>CPF (somente números)</label>
                <input type="text" class="form-control" maxlength="11" name="cpf" value="<?=$resultado->cpf?>">
            </div>
            <div class="form-group">
              <label>Plano Dentário</label><br>
              <select id="select-paciente" name="plano_dentario">
                <?php foreach ($planos as $row) { $selected = ($row->id == $resultado->plano_dentario_id) ? "selected='selected'" : ""; ?>
                <option value="<?= $row->id; ?>" <?=$selected?>><?= htmlspecialchars($row->nome) ?></option>
                <?php } ?>
              </select>
            </div>
            <input type="hidden" name="id" value="<?= htmlspecialchars($resultado->id) ?>">
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
