<?php
require_once __DIR__ . '/../app/bootstrap.php';

use ClinicaOdontologica\Controllers\PacienteCreateController;

$controller = new PacienteCreateController();
$data = $controller->handleRequest();

include_once __DIR__ . '/_common/header.php';

// compatibility variables for existing template
$flag = $data['flag'] ?? 0;
$nome = $data['values']['nome'] ?? '';
$sobrenome = $data['values']['sobrenome'] ?? '';
$nascimento = $data['values']['nascimento'] ?? '';
$cpf = $data['values']['cpf'] ?? '';
$planoDentarioList = $data['planos'] ?? [];
?>
  <body class="bg-dark">

    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">
          Cadastro de Paciente
        </div>
        <div class="card-body">
        <?php if ($flag == 1) { ?>
          <div class="alert alert-danger form-group" role="alert">
            <b>O CPF informado não é válido</b>
          </div>
          <form action="PacienteCreate.php" name="cadastrarPaciente" method="post">
            <div class="form-group">
                <label>Primeiro nome</label>
                <input type="text" class="form-control" required="required" autofocus="autofocus" name="nome" value="<?=$nome?>">
            </div>
            <div class="form-group">
                <label>Sobrenome</label>
                <input type="text" class="form-control" required="required" name="sobrenome" value="<?=$sobrenome?>">
            </div>
            <div class="form-group">
                <label>Data de nascimento</label>
                <input type="date" class="form-control" required="required" name="nascimento" value="<?=$nascimento?>">
            </div>
            <div class="form-group">
                <label>CPF (somente números)</label>
                <input type="text" class="form-control" maxlength="11" name="cpf" value="<?=$cpf?>">
            </div>
            <div class="form-group">
              <label>Plano Dentário</label><br>
              <select id="select-paciente" name="plano_dentario">
                <?php
                $planoDentario = new \ClinicaOdontologica\Models\PlanoDentario();
            $stmt = $planoDentario->viewAll();

            while ($row = $stmt->fetch(PDO::FETCH_OBJ)) { ?>
                <option value= <?= $row->id; ?>> <?= $row->nome; ?> </option>
                <?php } ?>
              </select>
            </div>
            <button class="btn btn-primary btn-block" type="submit" name="botao">Cadastrar</button>
          </form>
        <?php } elseif ($flag == 2) { ?>
          <div class="alert alert-danger form-group" role="alert">
            <b>O CPF informado já foi cadastrado</b>
          </div>
          <form action="PacienteCreate.php" name="cadastrarPaciente" method="post">
            <div class="form-group">
                <label>Primeiro nome</label>
                <input type="text" class="form-control" required="required" autofocus="autofocus" name="nome" value="<?=$nome?>">
            </div>
            <div class="form-group">
                <label>Sobrenome</label>
                <input type="text" class="form-control" required="required" name="sobrenome" value="<?=$sobrenome?>">
            </div>
            <div class="form-group">
                <label>Data de nascimento</label>
                <input type="date" class="form-control" required="required" name="nascimento" value="<?=$nascimento?>">
            </div>
            <div class="form-group">
                <label>CPF (somente números)</label>
                <input type="text" class="form-control" maxlength="11" name="cpf" value="<?=$cpf?>">
            </div>
            <div class="form-group">
              <label>Plano Dentário</label><br>
              <select id="select-paciente" name="plano_dentario">
                <?php foreach ($planoDentarioList as $row) { ?>
                <option value="<?= $row->id; ?>"> <?= htmlspecialchars($row->nome); ?> </option>
                <?php } ?>
              </select>
            </div>
            <button class="btn btn-primary btn-block" type="submit" name="botao">Cadastrar</button>
          </form>
        <?php } else { ?>
          <form action="PacienteCreate.php" name="cadastrarPaciente" method="post">
            <div class="form-group">
                <label>Primeiro nome</label>
                <input type="text" class="form-control" required="required" autofocus="autofocus" name="nome">
            </div>
            <div class="form-group">
                <label>Sobrenome</label>
                <input type="text" class="form-control" required="required" name="sobrenome">
            </div>
            <div class="form-group">
                <label>Data de nascimento</label>
                <input type="date" class="form-control" required="required" name="nascimento">
            </div>
            <div class="form-group">
              <label>CPF (somente números)</label>
              <input type="text" class="form-control" maxlength="11" name="cpf">
            </div>
            <div class="form-group">
              <label>Plano Dentário</label><br>
              <select id="select-paciente" name="plano_dentario">
                <?php foreach ($planoDentarioList as $row) { $selected = ($row->nome == "Não") ? "selected='selected'" : ""; ?>
                <option value="<?= $row->id; ?>" <?= $selected ?>> <?= htmlspecialchars($row->nome); ?> </option>
                <?php } ?>
              </select>
            </div>
            <button class="btn btn-primary btn-block" type="submit" name="botao">Cadastrar</button>
          </form>
        <?php } ?>
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
