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


  <body class="bg-dark">
    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">
          Cadastro de Funcionário
        </div>
        <div class="card-body">
        <?php 

          $cargo = isset($_GET["cargo"])?$_GET["cargo"]:"";
          $lastid = isset($_GET["lastid"])?$_GET["lastid"]:"";

            if(isset($_POST['botao'])){

              $cargo = $_POST["cargo"];
              $lastid = $_POST["lastid"];

              if($cargo == "Auxiliar"){
                
                include_once "../../../php/classAuxiliar.php";
                $auxiliar = new Auxiliar();
                $auxiliar->setFuncionarioId($lastid);
                $estado = $auxiliar->insert();

              }elseif($cargo == "Recepcionista"){

                $nome_usuario = $_POST["nome_usuario"];
                $senha = $_POST["senha"];
                include_once "../../../php/classRecepcionista.php";
                $recepcionista = new Recepcionista();
                $recepcionista->setFuncionarioId($lastid);
                $recepcionista->setNomeUsuario($nome_usuario);
                $recepcionista->setSenha($senha);
                $estado = $recepcionista->insert();

              }elseif($cargo == "Administrador"){

                $nome_usuario = $_POST["nome_usuario"];
                $senha = $_POST["senha"];
                include_once "../../../php/classAdministrador.php";
                $administrador = new Administrador();
                $administrador->setFuncionarioId($lastid);
                $administrador->setSenha($senha);
                $administrador->setNomeUsuario($nome_usuario);
                $estado = $administrador->insert();

              }elseif($cargo == "Dentista"){
                $cro = $_POST["cro"];
                include_once "../../../php/classDentista.php";
                $dentista = new Dentista();
                $dentista->setFuncionarioId($lastid);
                $dentista->setCro($cro);
                $estado = $dentista->insert();
              }  
            header("Location: ../index.php");
            }
            ?>
          <form action="cadastrar-funcionario-detalhado.php" method="post">
  	<?php  if ($cargo == "Recepcionista" || $cargo == "Administrador") { ?>
            <div class="form-group">
              <label>Nome de usuário</label>
              <input type="text" class="form-control" required="required" autofocus="autofocus" name="nome_usuario">
            </div>
            <div class="form-group">
              <label>Senha</label>
              <input type="password" class="form-control" required="required" autofocus="autofocus" name="senha">
            </div>
    <?php } elseif ($cargo == "Dentista") { ?>
            <div class="form-group">
              <label>CRO</label>
              <input type="text" class="form-control" required="required" autofocus="autofocus" maxlength="7" name="cro">
            </div> 
    <?php } ?>
                <input type="hidden" name="lastid" value=<?=$lastid?>>
                <input type="hidden" name="cargo" value=<?=$cargo?>>
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
