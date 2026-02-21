<?php include_once"header.php" ?>
<?php

$flag = 0;

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

    $nome_dentista = (request()->getParsedBody()['nome_dentista'] ?? request()->getQueryParams()['nome_dentista'] ?? null);
    $cro_dentista = (request()->getParsedBody()['cro_dentista'] ?? request()->getQueryParams()['cro_dentista'] ?? null);
    $especialidade = (request()->getParsedBody()['especialidade'] ?? request()->getQueryParams()['especialidade'] ?? null);

    if (!($id_dentista = $d->existeNomeCro($nome_dentista, $cro_dentista))) {
        $flag = 1;
    }

    if ($flag == 0) {
        $dhe->setDentistaId($id_dentista);
        $dhe->setEspecialidadeNome($especialidade);
        if ($dhe->viewDentistaHasEspecialidade()) {
            $flag = 2;
        }
    }

    if ($flag == 0) {
        $dhe->insert();
        header("Location: ../especialidades-dentistas.php");
    }

}?>
  <body class="bg-dark">

    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">
          Cadastro de Especialidade para Dentista
             <div class="float-right">
                <a href="../complementos/d-e.php" target="_blank" class="btn">Buscar dentistas</a>
            </div>
        </div>
        <div class="card-body">
        <?php if ($flag == 1) { ?>
          <div class="alert alert-danger form-group" role="alert">
            <b>O nome e o CRO informados não estão cadastrados ou não coincidem</b>
          </div>
        <?php } elseif ($flag == 2) { ?>
          <div class="alert alert-danger form-group" role="alert">
            <b>Combinação de dentista e especialidade já cadastrada</b>
          </div>
        <?php } ?>
          <form action="cadastrar-especialidade-dentista.php" method="post">
            <div class="form-group">
                <label>Nome do Dentista</label>
                <input type="text" class="form-control" required="required" name="nome_dentista" value="<?= $nome_dentista ?>">
            </div>
            <div class="form-group">
                <label>CRO do Dentista</label>
                <input type="text" class="form-control" maxlength="5" name="cro_dentista" value="<?= $cro_dentista ?>">
            </div>
            <div class="form-group">
                <label>Especialidade</label><br>
                <select name="especialidade">
                <?php

                $e = new \ClinicaOdontologica\Models\Especialidade();
$stmt = $e->viewAll();

while ($row = $stmt->fetch(PDO::FETCH_OBJ)) { ?>
                <option value= <?= $row->nome; ?>> <?= $row->nome; ?> </option>
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


