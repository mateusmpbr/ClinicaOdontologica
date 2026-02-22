<?php include_once __DIR__ . '/../_partials/header.php' ?>
<?php

$flag = 0;

if (has_input('botao')) {

    $id = (request()->getParsedBody()['id'] ?? request()->getQueryParams()['id'] ?? null);
    $descricao = (request()->getParsedBody()['descricao'] ?? request()->getQueryParams()['descricao'] ?? null);
    $valor = (request()->getParsedBody()['valor'] ?? request()->getQueryParams()['valor'] ?? null);

    $d = new \ClinicaOdontologica\Models\Despesa();
    $d->setId($id);
    $d->setDescricao($descricao);
    $d->setValor($valor);
    $d->edit();

    header('Location: despesas.php');

} else {

    $id = (request()->getParsedBody()['id'] ?? request()->getQueryParams()['id'] ?? null);
    $d = new \ClinicaOdontologica\Models\Despesa();
    $d->setId($id);
    $resultado = $d->viewDespesa();

}
?>

  <body class="bg-dark">

    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">
          Atualização de Despesa
        </div>
        <div class="card-body">
          <form action="editar-despesa.php" method="post">
            <div class="form-group">
                <label>Descrição</label>
                <input type="text" class="form-control" required="required" autofocus="autofocus" name="descricao" value="<?= $resultado->descricao ?>">
            </div>
            <div class="form-group">
                <label>Valor</label>
                <input type="number" class="form-control" required="required" name="valor" value="<?= $resultado->valor ?>">
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
