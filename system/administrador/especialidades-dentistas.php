<?php include_once'header.php' ?>
<?php

if (has_input('botao-remover')) {
    $dhe = new \ClinicaOdontologica\Models\DentistaHasEspecialidade();

    $dentista_id = (request()->getParsedBody()['dentista_id'] ?? request()->getQueryParams()['dentista_id'] ?? null);
    $especialidade_nome = (request()->getParsedBody()['especialidade_nome'] ?? request()->getQueryParams()['especialidade_nome'] ?? null);

    $dhe->setEspecialidadeNome($especialidade_nome);
    $dhe->setDentistaId($dentista_id);
    $dhe->delete();
}
?>
      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- DataTables Example -->
          <div class="card mb-3">

            <div>
              <button class="btn btn-primary btn-block" onclick="window.location.href='cadastrar/cadastrar-especialidade-dentista.php'" name="cadastrar-especialidade-dentista">Cadastrar Especialidade para Dentista</button>
            </div>

            <div class="card-header">
              <i class="fas fa-table"></i>
              Especialidades por Dentista</div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr align="center">
                      <th>Dentista</th>
                      <th>Especialidade</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr align="center">
                      <th>Dentista</th>
                      <th>Especialidade</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </tfoot>
                  <tbody>
                      <?php
                      $dhe = new \ClinicaOdontologica\Models\DentistaHasEspecialidade();

$stmt = $dhe->viewAll();

while ($row = $stmt->fetch(PDO::FETCH_OBJ)) { ?>
                      <tr align="center">
                        <?php
    $dhe->setDentistaId($row->dentista_id);
    $dentista_nome = $dhe->nomeDentista();
    ?>
                        <td> <?= $dentista_nome; ?> </td>
                        <td> <?= $row->especialidade_nome; ?> </td>
                        <td><a href="editar/editar-especialidade-dentista.php?dentista_id=<?=$row->dentista_id?>&especialidade_nome=<?=$row->especialidade_nome?>" class="btn btn-primary">Alterar</a></td>
                        <td><a href="#" class="btn btn-danger" data-toggle="modal" data-target="#removeModal<?=$row->dentista_id?>-<?=$row->especialidade_nome?>">Remover</a></td>
                      </tr>
                      <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- /.content-wrapper -->
<?php

      $stmt = $dhe->viewAll();

while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    $dhe->setDentistaId($row->dentista_id);
    $dentista_nome = $dhe->nomeDentista();
    $modalId = "removeModal{$row->dentista_id}-{$row->especialidade_nome}";
    $modalTitle = "Você tem certeza que deseja remover a especialidade {$row->especialidade_nome} do dentista {$dentista_nome} ?";
    $modalBody = "Essa ação não poderá ser desfeita";
    $formAction = "especialidades-dentistas.php";
    $hiddenFields = ['dentista_id' => $row->dentista_id, 'especialidade_nome' => $row->especialidade_nome];
    $confirmButtonName = 'botao-remover';
    $confirmButtonLabel = 'Remover';
    include __DIR__ . '/../_partials/modal-confirm.php';
}
include_once 'footer.php';
?>
