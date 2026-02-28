<?php include_once __DIR__ . '/_common/Header.php' ?>
<?php

$flag = 0;

// Inserção direta por IDs (formulário com selects)
if (!empty($_POST) && isset($_POST['dentista_id']) && isset($_POST['especialidade_id']) && !isset($_POST['botao'])) {
    $d = new \ClinicaOdontologica\Models\DentistaHasEspecialidade();
    $d->setDentistaId($_POST['dentista_id']);
    $d->setEspecialidadeId($_POST['especialidade_id']);
    $d->insert();
    header('Location: EspecialidadeDentistas.php');
    exit;
}

if (!has_input('nome_dentista')) {
    $nome_dentista = "";
}
if (!has_input('cro_dentista')) {
    $cro_dentista = "";
}

if (has_input('botao')) {

    $d = new \ClinicaOdontologica\Models\Dentista();
    $e = new \ClinicaOdontologica\Models\Especialidade();
    $dhe = new \ClinicaOdontologica\Models\DentistaHasEspecialidade();

    $nome_dentista = (request()->getParsedBody()['nome_dentista'] ?? request()->getQueryParams()['nome_dentista'] ?? null);
    $cro_dentista = (request()->getParsedBody()['cro_dentista'] ?? request()->getQueryParams()['cro_dentista'] ?? null);
    $especialidade = (request()->getParsedBody()['especialidade'] ?? request()->getQueryParams()['especialidade'] ?? null);

    if (!($id_dentista = $d->existeNomeCro($nome_dentista, $cro_dentista))) {
        $flag = 1;
    }

    if ($flag == 0) {
        $dhe->setDentistaId($id_dentista);
        $dhe->setEspecialidadeNome($especialidade);
        if ($dhe->viewDentistaHasEspecialidade()) {
            $flag = 2;
        }
    }

    if ($flag == 0) {
        $dhe->insert();
        header("Location: EspecialidadeDentistas.php");
        exit;
    }

}

?>

<body class="bg-dark">

  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Cadastro de Especialidade do Dentista</div>
      <div class="card-body">
        <form action="EspecialidadeDentistaCreate.php" method="post">
          <?= function_exists('csrf_field') ? csrf_field() : '' ?>
          <div class="form-group">
            <label>Dentista</label>
            <select name="dentista_id" class="form-control">
              <?php foreach ((new \ClinicaOdontologica\Models\Dentista())->all() as $dentista) { ?>
                <option value="<?= htmlspecialchars($dentista['id']) ?>"><?= htmlspecialchars($dentista['nome']) ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Especialidade</label>
            <select name="especialidade_id" class="form-control">
              <?php foreach ((new \ClinicaOdontologica\Models\Especialidade())->all() as $esp) { ?>
                <option value="<?= htmlspecialchars($esp['id']) ?>"><?= htmlspecialchars($esp['nome']) ?></option>
              <?php } ?>
            </select>
          </div>
          <button class="btn btn-primary btn-block" type="submit">Cadastrar</button>
        </form>
      </div>
    </div>

    <div class="card card-register mx-auto mt-4">
      <div class="card-header">
        Cadastro de Especialidade para Dentista
           <div class="float-right">
              <a href="Dentista.php" target="_blank" class="btn">Buscar dentistas</a>
          </div>
      </div>
      <div class="card-body">
      <?php if ($flag == 1) { ?>
        <div class="alert alert-danger form-group" role="alert">
          <b>O nome e o CRO informados não estão cadastrados ou não coincidem</b>
        </div>
      <?php } elseif ($flag == 2) { ?>
        <div class="alert alert-danger form-group" role="alert">
          <b>Combinação de dentista e especialidade já cadastrada</b>
        </div>
      <?php } ?>
        <form action="EspecialidadeDentistaCreate.php" method="post">
          <?= function_exists('csrf_field') ? csrf_field() : '' ?>
          <div class="form-group">
            <label>Nome do Dentista</label>
            <input type="text" class="form-control" required="required" name="nome_dentista" value="<?= htmlspecialchars($nome_dentista) ?>">
          </div>
          <div class="form-group">
            <label>CRO do Dentista</label>
            <input type="text" class="form-control" maxlength="5" name="cro_dentista" value="<?= htmlspecialchars($cro_dentista) ?>">
          </div>
          <div class="form-group">
              <label>Especialidade</label><br>
              <select name="especialidade">
              <?php

              $e = new \ClinicaOdontologica\Models\Especialidade();
$stmt = $e->viewAll();

while ($row = $stmt->fetch(PDO::FETCH_OBJ)) { ?>
              <option value="<?= htmlspecialchars($row->nome) ?>"> <?= htmlspecialchars($row->nome) ?> </option>
              <?php } ?>
              </select>
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
