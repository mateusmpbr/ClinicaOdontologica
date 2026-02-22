<?php include_once"header.php" ?>
<?php

$flag = 0;

if (has_input('botao')) {


    $nome = (request()->getParsedBody()['nome'] ?? request()->getQueryParams()['nome'] ?? null);
    $desconto = (request()->getParsedBody()['desconto'] ?? request()->getQueryParams()['desconto'] ?? null);

    $p = new \ClinicaOdontologica\Models\PlanoDentario();

    if ($p->existeNome($nome)) {
        $flag = 1;
    }

    if ($flag == 0) {
        $p->setNome($nome);
        $p->setDesconto($desconto);
        $p->insert();
        header("Location: planos-dentarios.php");
    }

} else {

    $nome = "";
    $desconto = "";

}
?>
<body class="bg-dark">

  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">
        Cadastro de Plano Dentário
      </div>
      <div class="card-body">
        <?php if ($flag == 1) { ?>
          <div class="alert alert-danger form-group" role="alert">
            <b>Esse plano dentário já está cadastrado</b>
          </div>
        <?php } ?>
        <form action="cadastrar-plano-dentario.php" method="post">
          <div class="form-group">
              <label>Nome</label>
              <input type="text" class="form-control" required="required" autofocus="autofocus" name="nome" value="<?=$nome?>">
          </div>
          <div class="form-group">
              <label>Desconto em %</label>
              <input type="number" class="form-control" required="required" name="desconto" value="<?=$desconto?>">
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
