<?php
require_once __DIR__ . '/../app/bootstrap.php';

use ClinicaOdontologica\Controllers\FuncionarioCreateController;

$controller = new FuncionarioCreateController();
$data = $controller->handleRequest();

include_once __DIR__ . '/_common/Header.php';

$flag = $data['flag'] ?? 0;
$step = $data['step'] ?? 0;
$values = $data['values'] ?? ['nome'=>'','sobrenome'=>'','nascimento'=>'','cpf'=>'','salario'=>'','cargo'=>''];
$resultado = $data['resultado'] ?? null;
$id = $data['id'] ?? ($values['id'] ?? null);
$cargo = $data['cargo'] ?? ($values['cargo'] ?? ($resultado->cargo ?? ''));
?>
<body class="bg-dark">

  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Cadastro de Funcionário</div>
      <div class="card-body">
        <?php if ($step === 0) : ?>
        <form action="FuncionarioCreate.php" method="post">
          <?= function_exists('csrf_field') ? csrf_field() : '' ?>
          <?= function_exists('csrf_field') ? csrf_field() : '' ?>
          <div class="form-group">
            <label>Nome</label>
            <input class="form-control" name="nome" required value="<?= htmlspecialchars($values['nome']) ?>">
          </div>
          <div class="form-group">
            <label>CPF</label>
            <input class="form-control" name="cpf" required value="<?= htmlspecialchars($values['cpf']) ?>">
          </div>
          <div class="form-group">
            <label>Salário</label>
            <input class="form-control" name="salario" required value="<?= htmlspecialchars($values['salario']) ?>">
          </div>
          <div class="form-group">
            <label>Cargo</label>
            <select name="cargo" class="form-control">
              <option value="Administrador">Administrador</option>
              <option value="Auxiliar">Auxiliar</option>
              <option value="Dentista">Dentista</option>
              <option value="Recepcionista">Recepcionista</option>
            </select>
          </div>
          <button class="btn btn-primary btn-block" type="submit" name="botao">Avançar</button>
        </form>
        <?php elseif ($step === 2) : ?>
        <form action="FuncionarioCreate.php" method="post">
          <?= function_exists('csrf_field') ? csrf_field() : '' ?>
          <?= function_exists('csrf_field') ? csrf_field() : '' ?>
          <?php if ($values['cargo'] === 'Recepcionista' || $values['cargo'] === 'Administrador') : ?>
            <div class="form-group">
              <label>Nome de usuário</label>
              <input type="text" class="form-control" required name="nome_usuario">
            </div>
            <div class="form-group">
              <label>Senha</label>
              <input type="password" class="form-control" required name="senha">
            </div>
          <?php elseif ($values['cargo'] === 'Dentista') : ?>
            <div class="form-group">
              <label>CRO</label>
              <input type="text" class="form-control" required maxlength="5" name="cro">
            </div>
          <?php endif; ?>
          <input type="hidden" name="nome" value="<?= htmlspecialchars($values['nome']) ?>">
          <input type="hidden" name="sobrenome" value="<?= htmlspecialchars($values['sobrenome']) ?>">
          <input type="hidden" name="nascimento" value="<?= htmlspecialchars($values['nascimento']) ?>">
          <input type="hidden" name="cpf" value="<?= htmlspecialchars($values['cpf']) ?>">
          <input type="hidden" name="salario" value="<?= htmlspecialchars($values['salario']) ?>">
          <input type="hidden" name="cargo" value="<?= htmlspecialchars($values['cargo']) ?>">
          <button class="btn btn-primary btn-block" type="submit" name="botao-detalhe">Cadastrar</button>
        </form>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <script src="/vendor/jquery/jquery.min.js"></script>
  <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>
</body>
</html>
