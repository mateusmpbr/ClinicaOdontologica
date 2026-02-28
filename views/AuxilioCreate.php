<?php
require_once __DIR__ . '/../app/bootstrap.php';

use ClinicaOdontologica\Controllers\AuxilioCreateController;

$controller = new AuxilioCreateController();
$data = $controller->handleRequest();

include_once __DIR__ . '/_common/header.php';
?>
  <body class="bg-dark">

    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">
          Cadastro de Auxílio
             <div class="float-right">
                <a href="auxiliar.php" target="_blank" class="btn">Buscar auxiliares</a>
                <a href="Dentista.php" target="_blank" class="btn">Buscar dentistas</a>
            </div>
        </div>
        <div class="card-body">
        <?php if (!empty($data['flag']) && $data['flag'] == 1) { ?>
          <div class="alert alert-danger form-group" role="alert">
            <b>O nome e o CRO do dentista não estão cadastrados ou não coincidem</b>
          </div>
        <?php } elseif (!empty($data['flag']) && $data['flag'] == 2) { ?>
          <div class="alert alert-danger form-group" role="alert">
            <b>O nome e o CPF do auxiliar não estão cadastrados ou não coincidem</b>
          </div>
        <?php } elseif (!empty($data['flag']) && $data['flag'] == 3) { ?>
          <div class="alert alert-danger form-group" role="alert">
            <b>Os dados informados não estão cadastrados ou não coincidem</b>
          </div>
        <?php } ?>
          <form action="AuxilioCreate.php" method="post">
            <div class="form-group">
                <label>Nome do Dentista</label>
                <input type="text" class="form-control" required="required" name="nome_dentista" value="<?= htmlspecialchars($data['values']['nome_dentista'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>CRO do Dentista</label>
                <input type="text" class="form-control" maxlength="5" name="cro_dentista" value="<?= htmlspecialchars($data['values']['cro_dentista'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Nome do Auxiliar</label>
                <input type="text" class="form-control" required="required" name="nome_auxiliar" value="<?= htmlspecialchars($data['values']['nome_auxiliar'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>CPF do Auxiliar (somente números)</label>
                <input type="text" class="form-control" maxlength="11" name="cpf_auxiliar" value="<?= htmlspecialchars($data['values']['cpf_auxiliar'] ?? '') ?>">
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
