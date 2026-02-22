<?php include_once __DIR__ . '/../_partials/header.php' ?>
<?php
$d = new \ClinicaOdontologica\Models\Despesa();

if (has_input('botao-remover')) {

    $id = (request()->getParsedBody()['id'] ?? request()->getQueryParams()['id'] ?? null);

    $d->setId($id);
    $d->delete();

}
?>
      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- DataTables Example -->
          <div class="card mb-3">

            <div>
              <button class="btn btn-primary btn-block" onclick="window.location.href='cadastrar-despesa.php'" name="cadastrar-despesa">Cadastrar Despesa</button>
            </div>

            <div class="card-header">
              <i class="fas fa-table"></i>
              Despesas</div>

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

                      $stmt = $d->viewAll();

while ($row = $stmt->fetch(PDO::FETCH_OBJ)) { ?>
                      <tr align="center">
                        <td> <?= $row->nome; ?> </td>
                        <td> <?= $row->data; ?> </td>
                        <td> <?= $row->valor; ?> </td>
                        <td> <?= $row->tipo; ?> </td>
                        <td> <?= $row->situacao; ?> </td>
                        <?php
    $d->setId($row->id);
    $administrador = $d->nomeAdministrador();
    ?>
                        <td> <?=  $administrador; ?> </td>
                        <td><a href="editar-despesa.php?id=<?=$row->id?>" class="btn btn-primary">Alterar</a></td>
                        <td><a href="#" class="btn btn-danger" data-toggle="modal" data-target="#removeModal<?=$row->id?>">Remover</a></td>
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

            $stmt = $d->viewAll();

      while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
          $modalId = "removeModal{$row->id}";
          $modalTitle = "Você tem certeza que deseja remover a despesa {$row->nome}?";
          $modalBody = "Essa ação não poderá ser desfeita";
          $formAction = "despesas.php";
          $hiddenFields = ['id' => $row->id];
          $confirmButtonName = 'botao-remover';
          $confirmButtonLabel = 'Remover';
          include __DIR__ . '/../_partials/modal-confirm.php';
      }
      include_once __DIR__ . '/../_partials/footer.php';
      ?>
