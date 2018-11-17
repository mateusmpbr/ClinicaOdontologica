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
  <?php 
  
  $flag = 0;

  if(isset($_POST['botao'])){ 
    include_once "../../../php/classFuncionario.php";
    
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $nascimento = $_POST['nascimento'];
    $cpf = $_POST['cpf'];
    $salario = $_POST['salario'];
    $cargo = $_POST['cargo'];

    $funcionario = new Funcionario();
    
    $funcionario->setNome($nome);
    $funcionario->setSobrenome($sobrenome);
    $funcionario->setNascimento($nascimento);
    $funcionario->setSalario($salario);
    $funcionario->setCargo($cargo);
    $funcionario->setCpf($cpf);
    if(!$funcionario->validaCPF($cpf)) $flag = 1;
    if($flag == 0){ 
        $lastid = $funcionario->insert();
        header("Location:cadastrar-funcionario-detalhado.php?lastid=$lastid&cargo=$cargo");
    }
    
  }?>
  <body class="bg-dark">

    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">
          Cadastro de Funcionário
        </div>
        <div class="card-body">
        <?php if($flag == 1) { ?>
          <div class="alert alert-danger form-group" role="alert">
            <b>O CPF informado não é válido</b>
          </div>
        <?php } ?>
          <form action="cadastrar-funcionario.php" method="post">
            <div class="form-group">
                <label>Primeiro nome</label>
                <input type="text" class="form-control" required="required" autofocus="autofocus" name="nome">
            </div>
            <div class="form-group">
                <label>Sobrenome</label>
                <input type="text" class="form-control" required="required" name="sobrenome">
            </div>
            <div class="form-group">
                <label>Data de nascimento</label>
                <input type="date" class="form-control" required="required" name="nascimento">
            </div>
            <div class="form-group">
                <label>CPF</label>
                <input type="text" class="form-control" maxlength="11" name="cpf">
            </div>
            <div class="form-group">
                <label>Salário</label>
                <input type="number" class="form-control" required="required" name="salario">
            </div>
            <div class="form-group">
              <select id="select-funcionario" name="cargo">
                <option value="Administrador">Administrador</option>
                <option value="Auxiliar">Auxiliar</option>
                <option value="Dentista">Dentista</option>
                <option value="Recepcionista">Recepcionista</option>
              </select>
            </div>
            <button class="btn btn-primary btn-block" type="submit" name="botao">Avançar</button>
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


