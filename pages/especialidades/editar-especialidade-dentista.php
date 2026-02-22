<?php include_once __DIR__ . '/../_partials/header.php' ?>
<?php

if (has_input('botao')) {

    $dentista_id = (request()->getParsedBody()['dentista_id'] ?? request()->getQueryParams()['dentista_id'] ?? null);
    $especialidade_id = (request()->getParsedBody()['especialidade_id'] ?? request()->getQueryParams()['especialidade_id'] ?? null);
    $resultado_id = (request()->getParsedBody()['resultado_id'] ?? request()->getQueryParams()['resultado_id'] ?? null);

    $dhe = new \ClinicaOdontologica\Models\DentistaHasEspecialidade();
    $dhe->setDentistaId($dentista_id);
    $dhe->setEspecialidadeId($especialidade_id);
    $dhe->edit($resultado_id);

    header('Location: especialidades-dentistas.php');

} else {
    $resultado_id = (request()->getParsedBody()['resultado_id'] ?? request()->getQueryParams()['resultado_id'] ?? null);
    $dhe = new \ClinicaOdontologica\Models\DentistaHasEspecialidade();
    $dhe->setId($resultado_id);
    $resultado = $dhe->view();
}

?>

  <body class="bg-dark">

    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">
          Atualização de Especialidade do Dentista
             <div class="float-right">
                <a href="d-e.php" target="_blank" class="btn">Buscar dentistas</a>
            </div>
        </div>
        <div class="card-body">
          <form action="editar-especialidade-dentista.php" method="post">
            <div class="form-group">
              <label>Dentista</label>
              <select name="dentista_id" class="form-control">
                <?php foreach ((new \ClinicaOdontologica\Models\Dentista())->all() as $dentista) { ?>
                  <option value="<?=$dentista['id']?>" <?=($dentista['id']==$resultado->dentista_id)?'selected':''?>><?=$dentista['nome']?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label>Especialidade</label>
              <select name="especialidade_id" class="form-control">
                <?php foreach ((new \ClinicaOdontologica\Models\Especialidade())->all() as $esp) { ?>
                  <option value="<?=$esp['id']?>" <?=($esp['id']==$resultado->especialidade_id)?'selected':''?>><?=$esp['nome']?></option>
                <?php } ?>
              </select>
            </div>
            <input type="hidden" name="resultado_id" value=<?=$resultado_id?>>
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
