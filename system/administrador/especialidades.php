<?php include_once'header.php' ?>
<?php

if (has_input('botao-remover')) {

    $nome = (request()->getParsedBody()['nome'] ?? request()->getQueryParams()['nome'] ?? null);

    $e = new \ClinicaOdontologica\Models\Especialidade();
    $e->setNome($nome);
    $e->delete();
}

?>
      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- DataTables Example -->
          <div class="card mb-3">

            <div>
              <button class="btn btn-primary btn-block" onclick="window.location.href='cadastrar/cadastrar-especialidade.php'" name="especialidade">Cadastrar Especialidade</button>
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
                      <?php
                      $e = new \ClinicaOdontologica\Models\Especialidade();
$stmt = $e->viewAll();

while ($row = $stmt->fetch(PDO::FETCH_OBJ)) { ?>
                      <tr align="center">
                        <td> <?= $row->nome; ?> </td>
                        <td><a href="editar/editar-especialidade?nome=<?=$row->nome?>" class="btn btn-primary">Alterar</a></td>
                        <td><a href="#" class="btn btn-danger" data-toggle="modal" data-target="#removeModal<?=$row->nome?>">Remover</a></td>
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

            $stmt = $e->viewAll();

      while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
          $modalId = "removeModal{$row->nome}";
          $modalTitle = "Você tem certeza que deseja remover a especialidade {$row->nome}?";
          $modalBody = "Essa ação não poderá ser desfeita";
          $formAction = "especialidades.php";
          $hiddenFields = ['nome' => $row->nome];
          $confirmButtonName = 'botao-remover';
          $confirmButtonLabel = 'Remover';
          include __DIR__ . '/../_partials/modal-confirm.php';
      }
      include_once 'footer.php';
      ?>
