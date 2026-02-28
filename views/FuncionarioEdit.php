<?php
require_once __DIR__ . '/../app/bootstrap.php';

use ClinicaOdontologica\Controllers\FuncionarioEditController;

$controller = new FuncionarioEditController();
$data = $controller->handleRequest();

include_once __DIR__ . '/_common/Header.php';

$errors = $data['errors'] ?? [];
$step = $data['step'] ?? 0;
$values = $data['values'] ?? [];
$resultado = $data['resultado'] ?? null;
$id = $data['id'] ?? ($values['id'] ?? null);
$cargo = $data['cargo'] ?? ($values['cargo'] ?? ($resultado->cargo ?? ''));
?>
  <body class="bg-dark">

    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">
          Atualização de Funcionário
        </div>
        <div class="card-body">
        <?php if ($step == 0) { ?>
          <form action="FuncionarioEdit.php" method="post">
            <?= function_exists('csrf_field') ? csrf_field() : '' ?>
            <?= function_exists('csrf_field') ? csrf_field() : '' ?>
            <div class="form-group">
                <label>Primeiro nome</label>
                <input type="text" class="form-control" required="required" autofocus="autofocus" name="nome" value="<?= htmlspecialchars($resultado->nome ?? $values['nome'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Sobrenome</label>
                <input type="text" class="form-control" required="required" name="sobrenome" value="<?= htmlspecialchars($resultado->sobrenome ?? $values['sobrenome'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Data de nascimento</label>
                <input type="date" class="form-control" required="required" name="nascimento" value="<?= htmlspecialchars($resultado->nascimento ?? $values['nascimento'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>CPF (somente números)</label>
                <input type="text" class="form-control" maxlength="11" name="cpf" value="<?= htmlspecialchars($resultado->cpf ?? $values['cpf'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Salário</label>
                <input type="number" step="0.01" class="form-control" required="required" name="salario" value="<?= htmlspecialchars($resultado->salario ?? $values['salario'] ?? '') ?>">
            </div>
            <input type="hidden" name="id" value="<?= htmlspecialchars($id ?? '') ?>">
            <input type="hidden" name="cargo" value="<?= htmlspecialchars($cargo ?? '') ?>">
            <button class="btn btn-primary btn-block" type="submit" name="botao">Avançar</button>
          </form>
        <?php } elseif (!empty($errors['cpf'])) { ?>
          <div class="alert alert-danger form-group" role="alert">
            <b>O CPF informado não é válido</b>
          </div>
          <form action="FuncionarioEdit.php" method="post">
            <div class="form-group">
                <label>Primeiro nome</label>
                <input type="text" class="form-control" required="required" autofocus="autofocus" name="nome" value="<?= htmlspecialchars($values['nome'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Sobrenome</label>
                <input type="text" class="form-control" required="required" name="sobrenome" value="<?= htmlspecialchars($values['sobrenome'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Data de nascimento</label>
                <input type="date" class="form-control" required="required" name="nascimento" value="<?= htmlspecialchars($values['nascimento'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>CPF (somente números)</label>
                <input type="text" class="form-control" maxlength="11" name="cpf">
            </div>
            <div class="form-group">
                <label>Salário</label>
                <input type="number" step="0.01" class="form-control" required="required" name="salario" value="<?= htmlspecialchars($values['salario'] ?? '') ?>"> 
            </div>
            <input type="hidden" name="id" value="<?= htmlspecialchars($id ?? '') ?>">
            <input type="hidden" name="cargo" value="<?= htmlspecialchars($cargo ?? '') ?>">
            <button class="btn btn-primary btn-block" type="submit" name="botao">Avançar</button>
          </form>
       <?php } elseif ($step == 2) { ?>
          <form action="FuncionarioEdit.php" method="post">
    <?php  if ($cargo === 'Recepcionista' || $cargo === 'Administrador') { ?>
            <div class="form-group">
              <label>Nome de usuário</label>
              <input type="text" class="form-control" required="required" autofocus="autofocus" name="nome_usuario" value="<?= htmlspecialchars($resultado->nome_usuario ?? '') ?>">
            </div>
            <div class="form-group">
              <label>Senha</label>
              <input type="password" class="form-control" required="required" autofocus="autofocus" name="senha">
            </div>
    <?php } elseif ($cargo === 'Dentista') { ?>
            <div class="form-group">
              <label>CRO</label>
              <input type="text" class="form-control" required="required" autofocus="autofocus" maxlength="5" name="cro" value="<?= htmlspecialchars($resultado->cro ?? '') ?>">
            </div> 
        <?php } ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($id ?? '') ?>">
            <input type="hidden" name="nome" value="<?= htmlspecialchars($values['nome'] ?? '') ?>">
            <input type="hidden" name="sobrenome" value="<?= htmlspecialchars($values['sobrenome'] ?? '') ?>">
            <input type="hidden" name="nascimento" value="<?= htmlspecialchars($values['nascimento'] ?? '') ?>">
            <input type="hidden" name="cpf" value="<?= htmlspecialchars($values['cpf'] ?? '') ?>">
            <input type="hidden" name="salario" value="<?= htmlspecialchars($values['salario'] ?? '') ?>">
            <input type="hidden" name="cargo" value="<?= htmlspecialchars($cargo ?? '') ?>">
            <button class="btn btn-primary btn-block" type="submit" name="botao-detalhe">Atualizar</button>
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
