<?php
require_once __DIR__ . '/../../app/bootstrap.php';
include_once __DIR__ . '/../_partials/header.php';

// Include appropriate sidebar depending on logged-in role
if (isset($_SESSION['funcionario'])) {
  $a = new \ClinicaOdontologica\Models\Administrador();
  $a->setFuncionarioId($_SESSION['funcionario']);
  if (!empty($a->viewAdministrador())) {
    include __DIR__ . '/../administrador/sidebar.php';
  } else {
    $r = new \ClinicaOdontologica\Models\Recepcionista();
    $r->setFuncionarioId($_SESSION['funcionario']);
    if (!empty($r->viewRecepcionista())) {
      include __DIR__ . '/../recepcionista/sidebar.php';
    }
  }
}

$p = new \ClinicaOdontologica\Models\PlanoDentario();

if (has_input('botao-remover')) {

    $id = (request()->getParsedBody()['id'] ?? request()->getQueryParams()['id'] ?? null);

    $p->setId($id);
    $p->delete();

}

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
              <button class="btn btn-primary btn-block" onclick="window.location.href='cadastrar-plano-dentario.php'" name="plano-dentario">Cadastrar Plano Dentário</button>
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
                      <?php


                      $stmt = $p->viewAll();

while ($row = $stmt->fetch(PDO::FETCH_OBJ)) { ?>
                      <tr align="center">
                        <td> <?= $row->nome; ?> </td>
                        <td> <?= $row->desconto."%"; ?> </td>
                        <?php if ($isAdmin) : ?>
                        <td><a href="editar-plano-dentario.php?id=<?=$row->id?>" class="btn btn-primary">Alterar</a></td>
                        <td><a href="#" class="btn btn-danger" data-toggle="modal" data-target="#removeModal<?=$row->id?>">Remover</a></td>
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

      $stmt = $p->viewAll();

while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    $modalId = "removeModal{$row->id}";
    $modalTitle = "Você tem certeza que deseja remover o plano dentário {$row->nome}?";
    $modalBody = "Essa ação não poderá ser desfeita";
    $formAction = "planos-dentarios.php";
    $hiddenFields = ['id' => $row->id];
    $confirmButtonName = 'botao-remover';
    $confirmButtonLabel = 'Remover';
    include __DIR__ . '/../_partials/modal-confirm.php';
}
include_once __DIR__ . '/../_partials/footer.php';
?>
