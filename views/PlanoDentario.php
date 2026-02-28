<?php
require_once __DIR__ . '/../app/bootstrap.php';

use ClinicaOdontologica\Controllers\PlanoDentarioController;

$controller = new PlanoDentarioController();
$data = $controller->handleRequest();

include_once __DIR__ . '/_common/header.php';

// Include appropriate sidebar depending on logged-in role
if (isset($_SESSION['funcionario'])) {
  $a = new \ClinicaOdontologica\Models\Administrador();
  $a->setFuncionarioId($_SESSION['funcionario']);
  if (!empty($a->viewAdministrador())) {
    include __DIR__ . '/Administrador/sidebar.php';
  } else {
    $r = new \ClinicaOdontologica\Models\Recepcionista();
    $r->setFuncionarioId($_SESSION['funcionario']);
    if (!empty($r->viewRecepcionista())) {
      include __DIR__ . '/Recepcionista/sidebar.php';
    }
  }
}

$planos = $data['planos'] ?? [];

?>
      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- DataTables Example -->
          <div class="card mb-3">

            <?php
            // Show create button only for administrators
            $isAdmin = false;
            if (isset($_SESSION['funcionario'])) {
                $a = new \ClinicaOdontologica\Models\Administrador();
                $a->setFuncionarioId($_SESSION['funcionario']);
                if (!empty($a->viewAdministrador())) {
                    $isAdmin = true;
                }
            }
            ?>

            <?php if ($isAdmin) : ?>
            <div>
              <button class="btn btn-primary btn-block" onclick="window.location.href='PlanoDentarioCreate.php'" name="plano-dentario">Cadastrar Plano Dentário</button>
            </div>
            <?php endif; ?>

            <div class="card-header">
              <i class="fas fa-table"></i>
              Planos Dentários</div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr align="center">
                      <th>Nome</th>
                      <th>Desconto</th>
                      <?php if ($isAdmin) : ?><th></th><th></th><?php endif; ?>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr align="center">
                      <th>Nome</th>
                      <th>Desconto</th>
                      <?php if ($isAdmin) : ?><th></th><th></th><?php endif; ?>
                    </tr>
                  </tfoot>
                  <tbody>
                      <?php foreach ($planos as $row) { ?>
                      <tr align="center">
                        <td> <?= htmlspecialchars($row->nome); ?> </td>
                        <td> <?= htmlspecialchars($row->desconto) . "%"; ?> </td>
                        <?php if ($isAdmin) : ?>
                        <td><a href="PlanoDentarioEdit.php?id=<?= $row->id ?>" class="btn btn-primary">Alterar</a></td>
                        <td><a href="#" class="btn btn-danger" data-toggle="modal" data-target="#removeModal<?= $row->id ?>">Remover</a></td>
                        <?php endif; ?>
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

foreach ($planos as $row) {
  $modalId = "removeModal{$row->id}";
  $modalTitle = "Você tem certeza que deseja remover o plano dentário {$row->nome}?";
  $modalBody = "Essa ação não poderá ser desfeita";
  $formAction = "PlanoDentario.php";
  $hiddenFields = ['id' => $row->id];
  $confirmButtonName = 'botao-remover';
  $confirmButtonLabel = 'Remover';
    include __DIR__ . '/_common/ModalConfirm.php';
}
include_once __DIR__ . '/_common/footer.php';
?>
