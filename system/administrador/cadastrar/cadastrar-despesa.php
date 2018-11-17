<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cadastro</title>

    <!-- Bootstrap core CSS-->
    <link href="../../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="../../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="../../../css/sb-admin.css" rel="stylesheet">

    <link href="../../../css/style.css" rel="stylesheet">

  </head>
  <?php if(isset($_POST['botao'])){ 
    include_once "../../../php/classDespesa.php";
    
    $nome = $_POST['nome'];
    $data = $_POST['data'];
    $valor = $_POST['valor'];
    $tipo = $_POST['tipo'];
    $situacao = $_POST['situacao'];

    $d = new Despesa();
    
    $d->setNome($nome);
    $d->setData($data);
    $d->seValor($valor);
    $d->setTipo($tipo);
    $d->setSituacao($situacao);
    $d->insert();

    header("Location: ../index.php");
  }?>
  <body class="bg-dark">

    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">
          Cadastro de Despesa
        </div>
        <div class="card-body">
          <form action="cadastrar-despesa.php" method="post">
            <div class="form-group">
                <label>Nome</label>
                <input type="text" class="form-control" required="required" autofocus="autofocus" name="nome">
            </div>
            <div class="form-group">
                <label>Data</label>
                <input type="date" class="form-control" required="required" name="data">
            </div>
            <div class="form-group">
                <label>Valor</label>
                <input type="number" class="form-control" required="required" name="valor">
            </div>
            <div class="form-group">
                <label>Tipo</label><br>
                <select name="tipo">
                    <option value="Despesa geral">Despesa Geral</option>
                    <option value="Despesa com Funcionário">Despesa com Funcionário</option>
                </select>
            </div>
            <div class="form-group">
                <label>Situação</label><br>
                <select name="situacao">
                    <option value="Pago">Pago</option>
                    <option value="Não Pago">Não Pago</option>
                </select>
            </div>
            <button class="btn btn-primary btn-block" type="submit" name="botao">Cadastrar</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../../../vendor/jquery/jquery.min.js"></script>
    <script src="../../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../../vendor/jquery-easing/jquery.easing.min.js"></script>

  </body>
</html>

