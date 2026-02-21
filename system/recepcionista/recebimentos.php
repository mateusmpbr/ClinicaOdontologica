<?php include_once'header.php' ?>
<?php
$r = new \ClinicaOdontologica\Models\Recebimento();

if (has_input('botao-remover')) {

    $id = (request()->getParsedBody()['id'] ?? request()->getQueryParams()['id'] ?? null);

    $r->setId($id);
    $r->delete();

}
?>
      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- DataTables Example -->
          <div class="card mb-3">

            <div>
              <button class="btn btn-primary btn-block" onclick="window.location.href='cadastrar/cadastrar-recebimento.php'" name="cadastrar-recebimento">Cadastrar Recebimento</button>
            </div>

            <div class="card-header">
              <i class="fas fa-table"></i>
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

                      $stmt = $r->viewAll();

while ($row = $stmt->fetch(PDO::FETCH_OBJ)) { ?>
                      <tr align="center">
                        <td> <?= $row->valor; ?> </td>
                        <td> <?= $row->data; ?> </td>
                        <td> <?= $row->modo_pagamento ?> </td>
                        <?php
      $r->setId($row->id);
    $nome_recepcionista = $r->nomeRecepcionista();
    ?>
                        <td> <?= $nome_recepcionista; ?> </td>
                        <?php
        $nome_paciente = $r->nomePaciente();
    ?>
                        <td> <?=$nome_paciente; ?> </td>
                        <td><a href="editar/editar-recebimento.php?id=<?=$row->id?>" class="btn btn-primary">Alterar</a></td>
                        <?php $id = $row->id ?>
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
            $stmt = $r->viewAll();

      while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
          $modalId = "removeModal{$row->id}";
          $modalTitle = "Você tem certeza que deseja remover?";
          $modalBody = "Essa ação não poderá ser desfeita";
          $formAction = "recebimentos.php";
          $hiddenFields = ['id' => $row->id];
          $confirmButtonName = 'botao-remover';
          $confirmButtonLabel = 'Remover';
          include __DIR__ . '/../_partials/modal-confirm.php';
      }
      include_once 'footer.php';
      ?>
