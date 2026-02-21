<?php include_once"header.php" ?>
<?php

if (has_input('botao')) {

    $id = (request()->getParsedBody()['id'] ?? request()->getQueryParams()['id'] ?? null);
    $nome = (request()->getParsedBody()['nome'] ?? request()->getQueryParams()['nome'] ?? null);

    $e = new \ClinicaOdontologica\Models\Especialidade();
    $e->setId($id);
    $e->setNome($nome);
    $e->edit();

    header('Location: especialidades.php');

} else {
    $id = (request()->getParsedBody()['id'] ?? request()->getQueryParams()['id'] ?? null);
    $e = new \ClinicaOdontologica\Models\Especialidade();
    $e->setId($id);
    $resultado = $e->viewEspecialidade();
}

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
              <input type="text" class="form-control" required="required" autofocus="autofocus" name="nome" value="<?= $resultado->nome ?>">
            </div>
            <input type="hidden" name="id" value=<?=$id?>>
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
