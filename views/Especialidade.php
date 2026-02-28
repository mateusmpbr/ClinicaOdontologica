<?php
require_once __DIR__ . '/../app/bootstrap.php';

use ClinicaOdontologica\Controllers\EspecialidadeController;

$controller = new EspecialidadeController();
$data = $controller->handleRequest();

include_once __DIR__ . '/_common/header.php';

?>
      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- DataTables Example -->
          <div class="card mb-3">

            <div>
              <button class="btn btn-primary btn-block" onclick="window.location.href='EspecialidadeCreate.php'" name="especialidade">Cadastrar Especialidade</button>
            </div>

            <div class="card-header">
              <i class="fas fa-table"></i>
              Especialidades</div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr align="center">
                      <th>Nome</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr align="center">
                      <th>Nome</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </tfoot>
                  <tbody>
                      <?php foreach ($data['especialidades'] as $row) { ?>
                      <tr align="center">
                        <td> <?= htmlspecialchars($row->nome); ?> </td>
                        <td><a href="editar-especialidade.php?nome=<?= rawurlencode($row->nome) ?>" class="btn btn-primary">Alterar</a></td>
                        <td><a href="#" class="btn btn-danger" data-toggle="modal" data-target="#removeModal<?= htmlspecialchars($row->nome) ?>">Remover</a></td>
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
        foreach ($data['especialidades'] as $row) {
          $modalId = "removeModal{$row->nome}";
          $modalTitle = "Você tem certeza que deseja remover a especialidade {$row->nome}?";
          $modalBody = "Essa ação não poderá ser desfeita";
          $formAction = "especialidades.php";
          $hiddenFields = ['nome' => $row->nome];
          $confirmButtonName = 'botao-remover';
          $confirmButtonLabel = 'Remover';
          include __DIR__ . '/_common/modal-confirm.php';
        }
        include_once __DIR__ . '/_common/footer.php';
        ?>
