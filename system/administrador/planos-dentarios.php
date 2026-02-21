<?php include_once'header.php' ?>
<?php
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

            <div>
              <button class="btn btn-primary btn-block" onclick="window.location.href='cadastrar/cadastrar-plano-dentario.php'" name="plano-dentario">Cadastrar Plano Dentário</button>
            </div>

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
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr align="center">
                      <th>Nome</th>
                      <th>Desconto</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </tfoot>
                  <tbody>
                      <?php

                      $stmt = $p->viewAll();

while ($row = $stmt->fetch(PDO::FETCH_OBJ)) { ?>
                      <tr align="center">
                        <td> <?= $row->nome; ?> </td>
                        <td> <?= $row->desconto."%"; ?> </td>
                        <td><a href="editar/editar-plano-dentario.php?id=<?=$row->id?>" class="btn btn-primary">Alterar</a></td>
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
include_once 'footer.php';
?>
