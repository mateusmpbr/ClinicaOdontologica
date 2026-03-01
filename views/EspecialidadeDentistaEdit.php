<?php

require_once __DIR__ . '/../app/bootstrap.php';

if (has_input('botao')) {

  // original values (hidden fields)
  $orig_dentista_id = input('original_dentista_id', null);
  $orig_especialidade_nome = input('original_especialidade_nome', null);

  // new values from form
  $new_dentista_id = input('dentista_id', null);
  $new_especialidade_nome = input('especialidade_nome', null);

  $dhe = new \ClinicaOdontologica\Models\DentistaHasEspecialidade();
  // set current values so model can find the existing row
  $dhe->setDentistaId($orig_dentista_id);
  $dhe->setEspecialidadeNome($orig_especialidade_nome);
  // perform update with new values
  $dhe->edit($new_dentista_id, $new_especialidade_nome);

  header('Location: EspecialidadeDentistas.php');
  exit;

} else {
  // load by dentista_id + especialidade_nome (passed as query params)
  $dentista_id = (request()->getParsedBody()['dentista_id'] ?? request()->getQueryParams()['dentista_id'] ?? null);
  $especialidade_nome = (request()->getParsedBody()['especialidade_nome'] ?? request()->getQueryParams()['especialidade_nome'] ?? null);
  $dhe = new \ClinicaOdontologica\Models\DentistaHasEspecialidade();
  $dhe->setDentistaId($dentista_id);
  $dhe->setEspecialidadeNome($especialidade_nome);
  $resultado = $dhe->viewDentistaHasEspecialidade();
}

include_once __DIR__ . '/_common/Header.php'
?>

  <body class="bg-dark">

    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">
          Atualização de Especialidade do Dentista
             <div class="float-right">
                <a href="Dentista.php" target="_blank" class="btn">Buscar dentistas</a>
            </div>
        </div>
        <div class="card-body">
          <form action="EspecialidadeDentistaEdit.php" method="post">
            <?= function_exists('csrf_field') ? csrf_field() : '' ?>
            <div class="form-group">
              <label>Dentista</label>
              <select name="dentista_id" class="form-control">
                <?php foreach ((new \ClinicaOdontologica\Models\Dentista())->viewAll() as $dentista) { ?>
                  <option value="<?= htmlspecialchars($dentista['id']) ?>" <?=($dentista['id']==($resultado->dentista_id ?? $resultado->dentista_id))?'selected':''?>><?= htmlspecialchars($dentista['nome']) ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label>Especialidade</label>
              <select name="especialidade_nome" class="form-control">
                <?php foreach ((new \ClinicaOdontologica\Models\Especialidade())->viewAll() as $esp) { ?>
                  <option value="<?= htmlspecialchars($esp['nome']) ?>" <?=($esp['nome']==($resultado->especialidade_nome ?? ''))?'selected':''?>><?= htmlspecialchars($esp['nome']) ?></option>
                <?php } ?>
              </select>
            </div>
            <input type="hidden" name="original_dentista_id" value="<?= htmlspecialchars($resultado->dentista_id ?? $dentista_id ?? '') ?>">
            <input type="hidden" name="original_especialidade_nome" value="<?= htmlspecialchars($resultado->especialidade_nome ?? $especialidade_nome ?? '') ?>">
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
