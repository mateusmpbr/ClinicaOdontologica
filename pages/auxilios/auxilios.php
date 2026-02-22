<?php include_once __DIR__ . '/../_partials/header.php' ?>
<?php
$aad = new \ClinicaOdontologica\Models\AuxiliarAuxiliaDentista();

if (has_input('botao-remover')) {

    $dentista_id = (request()->getParsedBody()['dentista_id'] ?? request()->getQueryParams()['dentista_id'] ?? null);
    $auxiliar_id = (request()->getParsedBody()['auxiliar_id'] ?? request()->getQueryParams()['auxiliar_id'] ?? null);

    $aad->setDentistaId($dentista_id);
    $aad->setAuxiliarId($auxiliar_id);
    $aad->delete();
}

?>
      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- DataTables Example -->
          <div class="card mb-3">

            <div>
              <button class="btn btn-primary btn-block" onclick="window.location.href='cadastrar-auxilio.php'" name="cadastrar-recebimento">Cadastrar Auxílio</button>
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

                      $stmt = $aad->viewAll();

while ($row = $stmt->fetch(PDO::FETCH_OBJ)) { ?>
                      <tr align="center">
                        <?php
    $dentista_nome = $aad->nomeDentista($row->dentista_id, $row->auxiliar_id);
    ?>
                        <td> <?= $dentista_nome; ?> </td>
                        <?php
      $auxiliar_nome = $aad->nomeAuxiliar($row->dentista_id, $row->auxiliar_id);
    ?>
                        <td> <?= $auxiliar_nome; ?> </td>
                        <td><a href="editar-auxilio.php?dentista_id=<?=$row->dentista_id?>&auxiliar_id=<?=$row->auxiliar_id?>" class="btn btn-primary">Alterar</a></td>
                        <td><a href="#" class="btn btn-danger" data-toggle="modal" data-target="#removeModal<?=$row->dentista_id?>-<?=$row->auxiliar_id?>">Remover</a></td>
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

      $stmt = $aad->viewAll();

while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    $modalId = "removeModal{$row->dentista_id}-{$row->auxiliar_id}";
    $modalTitle = "Você tem certeza que deseja remover esse auxílio?";
    $modalBody = "Essa ação não poderá ser desfeita";
    $formAction = "auxilios.php";
    $hiddenFields = ['dentista_id' => $row->dentista_id, 'auxiliar_id' => $row->auxiliar_id];
    $confirmButtonName = 'botao-remover';
    $confirmButtonLabel = 'Remover';
    include __DIR__ . '/../_partials/modal-confirm.php';
}
include_once __DIR__ . '/../_partials/footer.php';
?>