<?php
require_once __DIR__ . '/../app/bootstrap.php';

use ClinicaOdontologica\Controllers\AuxilioController;

$controller = new AuxilioController();
$data = $controller->handleRequest();

include_once __DIR__ . '/_common/header.php';
?>
      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- DataTables Example -->
          <div class="card mb-3">

            <div>
              <button class="btn btn-primary btn-block" onclick="window.location.href='AuxilioCreate.php'" name="cadastrar-recebimento">Cadastrar Auxílio</button>
            </div>

            <div class="card-header">
              <i class="fas fa-table"></i>
              Auxílios</div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr align="center">
                      <th>Dentista</th>
                      <th>Auxiliar</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr align="center">
                      <th>Dentista</th>
                      <th>Auxiliar</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </tfoot>
                  <tbody>
                      <?php
                      $rows = $data['rows'] ?? [];
                      foreach ($rows as $row) { ?>
                      <tr align="center">
                        <td> <?= htmlspecialchars($row->dentista_nome) ?> </td>
                        <td> <?= htmlspecialchars($row->auxiliar_nome) ?> </td>
                        <td><a href="AuxilioEdit.php?dentista_id=<?= htmlspecialchars($row->dentista_id) ?>&auxiliar_id=<?= htmlspecialchars($row->auxiliar_id) ?>" class="btn btn-primary">Alterar</a></td>
                        <td><a href="#" class="btn btn-danger" data-toggle="modal" data-target="#removeModal<?= htmlspecialchars($row->dentista_id) ?>-<?= htmlspecialchars($row->auxiliar_id) ?>">Remover</a></td>
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
      $rows = $data['rows'] ?? [];
      foreach ($rows as $row) {
          $modalId = "removeModal{$row->dentista_id}-{$row->auxiliar_id}";
          $modalTitle = "Você tem certeza que deseja remover esse auxílio?";
          $modalBody = "Essa ação não poderá ser desfeita";
          $formAction = "auxilios.php";
          $hiddenFields = ['dentista_id' => $row->dentista_id, 'auxiliar_id' => $row->auxiliar_id];
          $confirmButtonName = 'botao-remover';
          $confirmButtonLabel = 'Remover';
          include __DIR__ . '/_common/modal-confirm.php';
      }
      include_once __DIR__ . '/_common/footer.php';
?>
