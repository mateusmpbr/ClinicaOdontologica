<?php
require_once __DIR__ . '/../app/bootstrap.php';

use ClinicaOdontologica\Controllers\ConsultaController;

$controller = new ConsultaController();
$data = $controller->handleRequest();

include_once __DIR__ . '/_common/header.php';

if (!empty($data['sidebar'])) {
    include $data['sidebar'];
}

$dcp = $data['dcp'];

?>
      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- DataTables Example -->
          <div class="card mb-3">

            <div>
              <button class="btn btn-primary btn-block" onclick="window.location.href='ConsultaCreate.php'" name="cadastrar-consulta">Cadastrar Consulta</button>
            </div>

            <div class="card-header">
              <i class="fas fa-table"></i>
              Consultas</div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr align="center">
                      <th>Operação</th>
                      <th>Paciente</th>
                      <th>Dentista</th>
                      <th>Data</th>
                      <th>Hora</th>
                      <th>Valor</th>
                      <th>Situação</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr align="center">
                      <th>Operação</th>
                      <th>Paciente</th>
                      <th>Dentista</th>
                      <th>Data</th>
                      <th>Hora</th>
                      <th>Valor</th>
                      <th>Situação</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </tfoot>
                  <tbody>
                      <?php foreach ($data['consultas'] as $row) { ?>
                      <tr align="center">
                        <td> <?= htmlspecialchars($row->operacao) ?> </td>
                        <?php
    $dcp->setId($row->id);
    $nome_paciente = $dcp->nomePaciente();
    ?>
                        <td> <?= htmlspecialchars($nome_paciente) ?> </td>
                        <?php
      $nome_dentista = $dcp->nomeDentista();
    ?>
                        <td> <?= htmlspecialchars($nome_dentista) ?> </td>
                        <td> <?= htmlspecialchars($row->data) ?> </td>
                        <td> <?= htmlspecialchars($row->horario) ?> </td>
                        <td> <?= htmlspecialchars($row->valor) ?> </td>
                        <td> <?= htmlspecialchars($row->situacao) ?> </td>
                        <td><a href="ConsultaEdit.php?id=<?= htmlspecialchars($row->id) ?>" class="btn btn-primary">Alterar</a></td>
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
foreach ($data['consultas'] as $row) {
    $modalId = "removeModal{$row->id}";
    $modalTitle = "Você tem certeza que deseja remover a consulta ?";
    $modalBody = "Essa ação não poderá ser desfeita";
    $formAction = "consultas.php";
    $hiddenFields = ['id' => $row->id];
    $confirmButtonName = 'botao-remover';
    $confirmButtonLabel = 'Remover';
        include __DIR__ . '/_common/ModalConfirm.php';
}
include_once __DIR__ . '/_common/footer.php';
?>
