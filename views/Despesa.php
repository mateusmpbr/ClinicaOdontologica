<?php
require_once __DIR__ . '/../app/bootstrap.php';

use ClinicaOdontologica\Controllers\DespesaController;

$controller = new DespesaController();
$data = $controller->handleRequest();

include_once __DIR__ . '/_common/Header.php';

if (!empty($data['sidebar'])) {
    include $data['sidebar'];
}
?>
      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- DataTables Example -->
          <div class="card mb-3">

            <div>
              <button class="btn btn-primary btn-block" onclick="window.location.href='DespesaCreate.php'" name="cadastrar-despesa">Cadastrar Despesa</button>
            </div>

            <div class="card-header">
              <i class="fas fa-table"></i>
              Despesas
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr align="center">
                      <th>Nome</th>
                      <th>Data</th>
                      <th>Valor</th>
                      <th>Tipo</th>
                      <th>Situação</th>
                      <th>Administrador</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr align="center">
                      <th>Nome</th>
                      <th>Data</th>
                      <th>Valor</th>
                      <th>Tipo</th>
                      <th>Situação</th>
                      <th>Administrador</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </tfoot>
                  <tbody>
                      <?php
                      $rows = $data['rows'] ?? [];
                      foreach ($rows as $row) { ?>
                      <tr align="center">
                        <td> <?= htmlspecialchars($row->nome) ?> </td>
                        <td> <?= htmlspecialchars($row->data) ?> </td>
                        <td> <?= htmlspecialchars($row->valor) ?> </td>
                        <td> <?= htmlspecialchars($row->tipo) ?> </td>
                        <td> <?= htmlspecialchars($row->situacao) ?> </td>
                        <td> <?= htmlspecialchars($row->administrador) ?> </td>
                        <td><a href="DespesaEdit.php?id=<?= htmlspecialchars($row->id) ?>" class="btn btn-primary">Alterar</a></td>
                        <td><a href="#" class="btn btn-danger" data-toggle="modal" data-target="#removeModal<?= htmlspecialchars($row->id) ?>">Remover</a></td>
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
        $modals = $data['modals'] ?? [];
        foreach ($modals as $m) {
          $modalId = $m['modalId'];
          $modalTitle = $m['modalTitle'];
          $modalBody = $m['modalBody'];
          $formAction = $m['formAction'];
          $hiddenFields = $m['hiddenFields'];
          $confirmButtonName = $m['confirmButtonName'];
          $confirmButtonLabel = $m['confirmButtonLabel'];
            include __DIR__ . '/_common/ModalConfirm.php';
        }
        include_once __DIR__ . '/_common/Footer.php';
        ?>
