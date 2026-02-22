<?php include_once'header.php' ?>
<?php

if (has_input('botao-remover')) {

    $id = (request()->getParsedBody()['id'] ?? request()->getQueryParams()['id'] ?? null);

    $f = new \ClinicaOdontologica\Models\Funcionario();
    $f->setId($id);
    $f->delete();

}
?>
      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- DataTables Example -->
          <div class="card mb-3">

            <div>
              <button class="btn btn-primary btn-block" onclick="window.location.href='cadastrar-funcionario.php'" name="cadastrar-funcionario">Cadastrar Funcionário</button>
            </div>

            <div class="card-header">
              <i class="fas fa-table"></i>
              Funcionários
              <div class="float-right">
                <form action="index.php" method="post">
                  <select name="cargo">
                    <option value="Administrador">Administrador</option>
                    <option value="Auxiliar">Auxiliar</option>
                    <option value="Dentista">Dentista</option>
                    <option value="Recepcionista">Recepcionista</option>
                  </select>
                  <button class="btn" name="btn">Buscar detalhes</button>
                </form>
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <?php
                $flag = 0;
if (has_input('btn')) {
    $cargo = (request()->getParsedBody()['cargo'] ?? request()->getQueryParams()['cargo'] ?? null);
    if ($cargo == "Administrador") {
        ?>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr align="center">
                          <th>Nome</th>
                          <th>Sobrenome</th>
                          <th>Data de nascimento</th>
                          <th>CPF</th>
                          <th>Salário</th>
                          <th>Cargo</th>
                          <th>Nome de Usuário</th>
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
                          <th>Salário</th>
                          <th>Cargo</th>
                          <th>Nome de Usuário</th>
                          <th></th>
                          <th></th>
                        </tr>
                      </tfoot>
                      <tbody>
                          <?php
                $a = new \ClinicaOdontologica\Models\Administrador();

        $stmt = $a->viewAll();

        while ($row = $stmt->fetch(PDO::FETCH_OBJ)) { ?>
                          <tr align="center">
                            <td> <?= $row->nome; ?> </td>
                            <td> <?= $row->sobrenome; ?> </td>
                            <td> <?= $row->nascimento; ?> </td>
                            <td> <?= empty($row->cpf) ? "" : $row->cpf; ?> </td>
                            <td> <?= $row->salario; ?> </td>
                            <td> <?= $row->cargo; ?> </td>
                            <td> <?= $row->nome_usuario; ?></td>
                            <td><a href="editar-funcionario.php?id=<?=$row->funcionario_id?>" class="btn btn-primary">Alterar</a></td>
                            <?php $id = $row->funcionario_id; ?>
                            <td><a href="#" class="btn btn-danger" data-toggle="modal" data-target="#removeModal<?=$row->id?>">Remover</a></td>
                          </tr>
                          <?php } ?>
                      </tbody>
                    </table>
                <?php
    } elseif ($cargo == "Recepcionista") {
        ?>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr align="center">
                          <th>Nome</th>
                          <th>Sobrenome</th>
                          <th>Data de nascimento</th>
                          <th>CPF</th>
                          <th>Salário</th>
                          <th>Cargo</th>
                          <th>Nome de Usuário</th>
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
                          <th>Salário</th>
                          <th>Cargo</th>
                          <th>Nome de Usuário</th>
                          <th></th>
                          <th></th>
                        </tr>
                      </tfoot>
                      <tbody>
                          <?php
                  $r = new \ClinicaOdontologica\Models\Recepcionista();

        $stmt = $r->viewAll();

        while ($row = $stmt->fetch(PDO::FETCH_OBJ)) { ?>
                          <tr align="center">
                            <td> <?= $row->nome; ?> </td>
                            <td> <?= $row->sobrenome; ?> </td>
                            <td> <?= $row->nascimento; ?> </td>
                            <td> <?= empty($row->cpf) ? "" : $row->cpf; ?> </td>
                            <td> <?= $row->salario; ?> </td>
                            <td> <?= $row->cargo; ?> </td>
                            <td> <?= $row->nome_usuario; ?></td>
                            <td><a href="editar-funcionario.php?id=<?=$row->funcionario_id?>" class="btn btn-primary">Alterar</a></td>
                            <?php $id = $row->funcionario_id; ?>
                            <td><a href="#" class="btn btn-danger" data-toggle="modal" data-target="#removeModal<?=$row->id?>">Remover</a></td>
                          </tr>
                          <?php } ?>
                      </tbody>
                    </table>
                <?php
    } elseif ($cargo == "Dentista") {
        ?>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr align="center">
                          <th>Nome</th>
                          <th>Sobrenome</th>
                          <th>Data de nascimento</th>
                          <th>CPF</th>
                          <th>Salário</th>
                          <th>Cargo</th>
                          <th>CRO</th>
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
                          <th>Salário</th>
                          <th>Cargo</th>
                          <th>CRO</th>
                          <th></th>
                          <th></th>
                        </tr>
                      </tfoot>
                      <tbody>
                          <?php
                  $d = new \ClinicaOdontologica\Models\Dentista();

        $stmt = $d->viewAll();

        while ($row = $stmt->fetch(PDO::FETCH_OBJ)) { ?>
                          <tr align="center">
                            <td> <?= $row->nome; ?> </td>
                            <td> <?= $row->sobrenome; ?> </td>
                            <td> <?= $row->nascimento; ?> </td>
                            <td> <?= empty($row->cpf) ? "" : $row->cpf; ?> </td>
                            <td> <?= $row->salario; ?> </td>
                            <td> <?= $row->cargo; ?> </td>
                            <td> <?= $row->cro; ?></td>
                            <td><a href="editar-funcionario.php?id=<?=$row->funcionario_id?>" class="btn btn-primary">Alterar</a></td>
                            <?php $id = $row->funcionario_id; ?>
                            <td><a href="#" class="btn btn-danger" data-toggle="modal" data-target="#removeModal<?=$row->id?>">Remover</a></td>
                          </tr>
                          <?php } ?>
                      </tbody>
                    </table>
                <?php
    } elseif ($cargo = "Auxiliar") {
        ?>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr align="center">
                          <th>Nome</th>
                          <th>Sobrenome</th>
                          <th>Data de nascimento</th>
                          <th>CPF</th>
                          <th>Salário</th>
                          <th>Cargo</th>
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
                          <th>Salário</th>
                          <th>Cargo</th>
                          <th></th>
                          <th></th>
                        </tr>
                      </tfoot>
                      <tbody>
                          <?php
                  $a = new \ClinicaOdontologica\Models\Auxiliar();

        $stmt = $a->viewAll();

        while ($row = $stmt->fetch(PDO::FETCH_OBJ)) { ?>
                          <tr align="center">
                            <td> <?= $row->nome; ?> </td>
                            <td> <?= $row->sobrenome; ?> </td>
                            <td> <?= $row->nascimento; ?> </td>
                            <td> <?= empty($row->cpf) ? "" : $row->cpf; ?> </td>
                            <td> <?= $row->salario; ?> </td>
                            <td> <?= $row->cargo; ?> </td>
                            <td><a href="editar-funcionario.php?id=<?=$row->funcionario_id?>" class="btn btn-primary">Alterar</a></td>
                            <?php $id = $row->funcionario_id; ?>
                            <td><a href="#" class="btn btn-danger" data-toggle="modal" data-target="#removeModal<?=$row->id?>">Remover</a></td>
                          </tr>
                          <?php } ?>
                      </tbody>
                    </table>
                <?php
    }
} else {
    ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr align="center">
                      <th>Nome</th>
                      <th>Sobrenome</th>
                      <th>Data de nascimento</th>
                      <th>CPF</th>
                      <th>Salário</th>
                      <th>Cargo</th>
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
                      <th>Salário</th>
                      <th>Cargo</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </tfoot>
                  <tbody>
                          <?php
              $f = new \ClinicaOdontologica\Models\Funcionario();

    $stmt = $f->viewAll();

    while ($row = $stmt->fetch(PDO::FETCH_OBJ)) { ?>
                      <tr align="center">
                        <td> <?= $row->nome; ?> </td>
                        <td> <?= $row->sobrenome; ?> </td>
                        <td> <?= $row->nascimento; ?> </td>
                        <td> <?= empty($row->cpf) ? "" : $row->cpf; ?> </td>
                        <td> <?= $row->salario; ?> </td>
                        <td> <?= $row->cargo; ?> </td>
                        <td><a href="editar-funcionario.php?id=<?=$row->id?>" class="btn btn-primary">Alterar</a></td>
                        <?php $id = $row->id; ?>
                        <td><a href="#" class="btn btn-danger" data-toggle="modal" data-target="#removeModal<?=$row->id?>">Remover</a></td>
                      </tr>
                      <?php } ?>
                  </tbody>
                </table>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- /.content-wrapper -->
      <?php
            $f = new \ClinicaOdontologica\Models\Funcionario();
      $stmt = $f->viewAll();

      while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
          $modalId = "removeModal{$row->id}";
          $modalTitle = "Você tem certeza que deseja remover?";
          $modalBody = "Essa ação não poderá ser desfeita";
          $formAction = "index.php";
          $hiddenFields = ['id' => $row->id];
          $confirmButtonName = 'botao-remover';
          $confirmButtonLabel = 'Remover';
          include __DIR__ . '/../_partials/modal-confirm.php';
      }
      include_once 'footer.php';
      ?>