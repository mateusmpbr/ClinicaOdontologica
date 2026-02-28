<?php include_once __DIR__ . '/../_partials/header.php' ?>
<?php

if (has_input('botao')) {

    $id = (request()->getParsedBody()['id'] ?? request()->getQueryParams()['id'] ?? null);
    $nome = (request()->getParsedBody()['nome'] ?? request()->getQueryParams()['nome'] ?? null);
    $desconto = (request()->getParsedBody()['desconto'] ?? request()->getQueryParams()['desconto'] ?? null);

    $p = new \ClinicaOdontologica\Models\PlanoDentario();
    $p->setId($id);
    $p->setNome($nome);
    $p->setDesconto($desconto);
    $p->edit();

    header('Location: planos-dentarios.php');

} else {
    $id = (request()->getParsedBody()['id'] ?? request()->getQueryParams()['id'] ?? null);
    $p = new \ClinicaOdontologica\Models\PlanoDentario();
    $p->setId($id);
    $resultado = $p->viewPlano();
}
?>

  <body class="bg-dark">

    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">
          Atualização de Plano Dentário
        </div>
        <div class="card-body">
          <form action="editar-plano-dentario.php" method="post">
            <div class="form-group">
                <label>Nome</label>
                <input type="text" class="form-control" required="required" autofocus="autofocus" name="nome" value="<?= $resultado->nome ?>">
            </div>
            <div class="form-group">
                <label>Desconto em %</label>
                <input type="number" class="form-control" required="required" name="desconto" value="<?= $resultado->desconto ?>">
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
