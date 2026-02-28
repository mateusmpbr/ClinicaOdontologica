<?php
require_once __DIR__ . '/../app/bootstrap.php';
include_once __DIR__ . '/_common/Header.php';

// Include appropriate sidebar depending on logged-in role
if (isset($_SESSION['funcionario'])) {
  $a = new \ClinicaOdontologica\Models\Administrador();
  $a->setFuncionarioId($_SESSION['funcionario']);
  if (!empty($a->viewAdministrador())) {
    include __DIR__ . '/Administrador/Sidebar.php';
  } else {
    $r = new \ClinicaOdontologica\Models\Recepcionista();
    $r->setFuncionarioId($_SESSION['funcionario']);
    if (!empty($r->viewRecepcionista())) {
      include __DIR__ . '/Recepcionista/Sidebar.php';
    }
  }
}

$dhe = new \ClinicaOdontologica\Models\DentistaHasEspecialidade();

if (has_input('botao-remover')) {
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
              <button class="btn btn-primary btn-block" onclick="window.location.href='EspecialidadeDentistaCreate.php'" name="cadastrar-especialidade-dentista">Cadastrar Especialidade para Dentista</button>
            </div>
            <?php endif; ?>

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
                      <?php if ($isAdmin) : ?><th></th><th></th><?php endif; ?>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr align="center">
                      <th>Dentista</th>
                      <th>Especialidade</th>
                      <?php if ($isAdmin) : ?><th></th><th></th><?php endif; ?>
                    </tr>
                  </tfoot>
                  <tbody>
                      <?php

$stmt = $dhe->viewAll();

while ($row = $stmt->fetch(PDO::FETCH_OBJ)) { ?>
                      <tr align="center">
                        <?php
    $dhe->setDentistaId($row->dentista_id);
    $dentista_nome = $dhe->nomeDentista();
    ?>
                        <td> <?= htmlspecialchars($dentista_nome) ?> </td>
                        <td> <?= htmlspecialchars($row->especialidade_nome) ?> </td>
                        <?php if ($isAdmin) : ?>
                        <td><a href="EspecialidadeDentistaEdit.php?dentista_id=<?= htmlspecialchars($row->dentista_id) ?>&especialidade_nome=<?= rawurlencode($row->especialidade_nome) ?>" class="btn btn-primary">Alterar</a></td>
                        <td><a href="#" class="btn btn-danger" data-toggle="modal" data-target="#removeModal<?= htmlspecialchars($row->dentista_id) ?>-<?= htmlspecialchars($row->especialidade_nome) ?>">Remover</a></td>
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

      $stmt = $dhe->viewAll();

while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    $dhe->setDentistaId($row->dentista_id);
    $dentista_nome = $dhe->nomeDentista();
    $modalId = "removeModal{$row->dentista_id}-{$row->especialidade_nome}";
    $modalTitle = "Você tem certeza que deseja remover a especialidade " . htmlspecialchars($row->especialidade_nome) . " do dentista " . htmlspecialchars($dentista_nome) . " ?";
    $modalBody = "Essa ação não poderá ser desfeita";
    $formAction = "EspecialidadeDentistas.php";
    $hiddenFields = ['dentista_id' => $row->dentista_id, 'especialidade_nome' => $row->especialidade_nome];
    $confirmButtonName = 'botao-remover';
    $confirmButtonLabel = 'Remover';
    include __DIR__ . '/_common/ModalConfirm.php';
}
include_once __DIR__ . '/_common/Footer.php';
?>
