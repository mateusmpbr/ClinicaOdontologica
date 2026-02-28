<?php
require_once __DIR__ . '/../app/bootstrap.php';

use ClinicaOdontologica\Controllers\RecebimentoController;

$controller = new RecebimentoController();
$data = $controller->handleRequest();

include_once __DIR__ . '/_common/Header.php';
?>
              Recebimentos</div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr align="center">
                      <th>Valor</th>
                      <th>Data</th>
                      <th>Modo de Pagamento</th>
                      <th>Recepcionista</th>
                      <th>Paciente</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr align="center">
                      <th>Valor</th>
                      <th>Data</th>
                      <th>Modo de Pagamento</th>
                      <th>Recepcionista</th>
                      <th>Paciente</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </tfoot>
                  <tbody>
                      <?php
                      $rows = $data['rows'] ?? [];
                      foreach ($rows as $row) { ?>
                      <tr align="center">
                        <td> <?= htmlspecialchars($row->valor) ?> </td>
                        <td> <?= htmlspecialchars($row->data) ?> </td>
                        <td> <?= htmlspecialchars($row->modo_pagamento) ?> </td>
                        <td> <?= htmlspecialchars($row->recepcionista) ?> </td>
                        <td> <?= htmlspecialchars($row->paciente) ?> </td>
                        <td><a href="RecebimentoEdit.php?id=<?= htmlspecialchars($row->id) ?>" class="btn btn-primary">Alterar</a></td>
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
