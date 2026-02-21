<?php include_once'header.php' ?>
<?php

if (has_input('botao-remover')) {
    $id = (request()->getParsedBody()['id'] ?? request()->getQueryParams()['id'] ?? null);
    $paciente = new \ClinicaOdontologica\Models\Paciente();
    $paciente->setId($id);
    $paciente->delete();
} ?>
      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- DataTables Example -->
          <div class="card mb-3">

            <div>
              <button class="btn btn-primary btn-block" onclick="window.location.href='cadastrar/cadastrar-paciente.php'" name="cadastrar-paciente">Cadastrar Paciente</button>
            </div>

            <div class="card-header">
              <i class="fas fa-table"></i>
              Pacientes</div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr align="center">
                      <th>Nome</th>
                      <th>Sobrenome</th>
                      <th>Data de nascimento</th>
                      <th>CPF</th>
                      <th>Plano Dentário</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr align="center">
                      <th>Nome</th>
                      <th>Sobrenome</th>
                      <th>Data de nascimento</th>
                      <th>CPF</th>
                      <th>Plano Dentário</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </tfoot>
                  <tbody>
                      <?php

                      $p = new \ClinicaOdontologica\Models\Paciente();
$stmt = $p->viewAll();

while ($row = $stmt->fetch(PDO::FETCH_OBJ)) { ?>
                      <tr align="center">
                        <td> <?= $row->nome; ?> </td>
                        <td> <?= $row->sobrenome; ?> </td>
                        <td> <?= $row->nascimento; ?> </td>
                        <td> <?= empty($row->cpf) ? "" : $row->cpf; ?> </td>
                        <?php
    $p->setId($row->id);
    $plano_dentario = $p->nomePlanoDentario();
    ?>
                        <td> <?= $plano_dentario; ?> </td>
                        <td><a href="editar/editar-paciente.php?id=<?=$row->id?>" class="btn btn-primary">Alterar</a></td>
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
    $modalTitle = "Você tem certeza que deseja remover o paciente {$row->nome} ?";
    $modalBody = "Essa ação não poderá ser desfeita";
    $formAction = "index.php";
    $hiddenFields = ['id' => $row->id];
    $confirmButtonName = 'botao-remover';
    $confirmButtonLabel = 'Remover';
    include __DIR__ . '/../_partials/modal-confirm.php';
}
include_once 'footer.php';
?>
