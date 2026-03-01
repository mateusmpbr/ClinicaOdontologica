<?php
require_once __DIR__ . '/../app/bootstrap.php';

$errors = [];

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

    $nome_dentista = input('nome_dentista', '');
    $cro_dentista = input('cro_dentista', '');
    $especialidade = input('especialidade', '');

    if (!($id_dentista = $d->existeNomeCro($nome_dentista, $cro_dentista))) {
      $errors['dentista'] = 'not_found';
    }

    if (empty($errors)) {
      $dhe->setDentistaId($id_dentista);
      $dhe->setEspecialidadeNome($especialidade);
      if ($dhe->viewDentistaHasEspecialidade()) {
        $errors['combination'] = 'duplicate';
      }
    }

    if (empty($errors)) {
      $dhe->insert();
      header("Location: EspecialidadeDentistas.php");
      exit;
    }
}

include_once __DIR__ . '/_common/Header.php';

?>

  <body class="bg-dark">
  <div class="container">
    <div class="card card-register mx-auto mt-4">
      <div class="card-header">
        Cadastro de Especialidade para Dentista
           <div class="float-right">
              <a href="Dentista.php" target="_blank" class="btn">Buscar dentistas</a>
          </div>
      </div>
      <div class="card-body">
      <?php if (!empty($errors['dentista'])) { ?>
        <div class="alert alert-danger form-group" role="alert">
          <b>O nome e o CRO informados não estão cadastrados ou não coincidem</b>
        </div>
      <?php } elseif (!empty($errors['combination'])) { ?>
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
                while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
              ?>
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
