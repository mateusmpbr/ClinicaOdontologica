<?php
require_once __DIR__ . '/../../../app/bootstrap.php';
verificaFuncionarioLogadoCadastro();
verificarRecepcionistaLogadoCadastro();


$flag = 0;

if (has_input('botao')) {

    $id = (request()->getParsedBody()['id'] ?? request()->getQueryParams()['id'] ?? null);
    $nome = (request()->getParsedBody()['nome'] ?? request()->getQueryParams()['nome'] ?? null);
    $sobrenome = (request()->getParsedBody()['sobrenome'] ?? request()->getQueryParams()['sobrenome'] ?? null);
    $nascimento = (request()->getParsedBody()['nascimento'] ?? request()->getQueryParams()['nascimento'] ?? null);
    $cpf = (request()->getParsedBody()['cpf'] ?? request()->getQueryParams()['cpf'] ?? null);
    $plano_dentario = (request()->getParsedBody()['plano_dentario'] ?? request()->getQueryParams()['plano_dentario'] ?? null);

    $paciente = new \ClinicaOdontologica\Models\Paciente();

    $paciente->setId($id);
    $paciente->setCPF($cpf);
    $paciente->setNome($nome);
    $paciente->setSobrenome($sobrenome);
    $paciente->setNascimento($nascimento);
    $paciente->setPlanoDentarioId($plano_dentario);
    if (!$paciente->validaCPF($cpf)) {
        $flag = 1;
        $resultado = $paciente->viewPaciente();
    }

    if ($paciente->existeCpf()) {
        $flag = 2;
        $resultado = $paciente->viewPaciente();
    }

    if ($flag == 0) {
        $p = $paciente->edit();
        header("Location: ../index.php");
        exit;
    }

} else {

    $id = (request()->getParsedBody()['id'] ?? request()->getQueryParams()['id'] ?? null);
    $paciente = new \ClinicaOdontologica\Models\Paciente();
    $paciente->setId($id);
    $resultado = $paciente->viewPaciente();

}

include_once"header.php";
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
          <form action="editar-paciente.php" method="post">
            <div class="form-group">
                <label>Primeiro nome</label>
                <input type="text" class="form-control" required="required" autofocus="autofocus" name="nome" value="<?=$resultado->nome?>">
            </div>
            <div class="form-group">
                <label>Sobrenome</label>
                <input type="text" class="form-control" required="required" name="sobrenome" value="<?=$resultado->sobrenome?>">
            </div>
            <div class="form-group">
                <label>Data de nascimento</label>
                <input type="date" class="form-control" required="required" name="nascimento" value="<?=$resultado->nascimento?>">
            </div>
            <div class="form-group">
                <label>CPF (somente números)</label>
                <input type="text" class="form-control" maxlength="11" name="cpf" value="<?=$resultado->cpf?>">
            </div>
            <div class="form-group">
              <label>Plano Dentário</label><br>
              <select id="select-paciente" name="plano_dentario">
                <?php
                $planoDentario = new \ClinicaOdontologica\Models\PlanoDentario();
$stmt = $planoDentario->viewAll();

while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    $selected = ($row->id == $resultado->plano_dentario_id) ? "selected='selected'" : ""; ?>
                <option value= "<?= $row->id; ?>" <?=$selected?>><?=$row->nome?></option>
                <?php } ?>
              </select>
            </div>
            <input type="hidden" name="id" value="<?=$id?>">
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


