<?php include_once"header.php" ?>
<?php

if (!empty($_POST)) {
    $e = new \ClinicaOdontologica\Models\Especialidade();
    $e->setNome($_POST['nome']);
    $e->insert();
    header('Location: especialidades.php');
}

?>

<body class="bg-dark">
  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Cadastro de Especialidade</div>
      <div class="card-body">
        <form action="cadastrar-especialidade.php" method="post">
          <div class="form-group">
            <label>Nome</label>
            <input class="form-control" name="nome" required>
          </div>
          <button class="btn btn-primary btn-block" type="submit">Cadastrar</button>
        </form>
      </div>
    </div>
  </div>

  <script src="/vendor/jquery/jquery.min.js"></script>
  <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>
</body>
</html>
<?php include_once"header.php" ?>
<?php

$flag = 0;

if (has_input('botao')) {
    $nome = (request()->getParsedBody()['nome'] ?? request()->getQueryParams()['nome'] ?? null);
    $e = new \ClinicaOdontologica\Models\Especialidade();
    $e->setNome($nome);

    if ($e->viewEspecialidade()) {
        $flag = 1;
    } else {
        $e->setNome($nome);
        $e->insert();

        header("Location: especialidades.php");
    }

} else {
    $nome = "";
}
?>
<body class="bg-dark">

  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">
        Cadastro de Especialidade
      </div>
      <div class="card-body">
        <?php if ($flag == 1) { ?>
          <div class="alert alert-danger form-group" role="alert">
            <b>Especialidade já cadastrada</b>
          </div>
        <?php } ?>
        <form action="cadastrar-especialidade.php" method="post">
          <div class="form-group">
              <label>Nome</label>
              <input type="text" class="form-control" required="required" autofocus="autofocus" name="nome" value="<?=$nome?>">
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
