<?php
require_once __DIR__ . '/../app/bootstrap.php';

use ClinicaOdontologica\Controllers\BalancoController;

$controller = new BalancoController();
$data = $controller->handleRequest();

include_once __DIR__ . '/_common/Header.php';
?>
      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- DataTables Example -->
          <div class="card mb-3">

            <div class="card-header">
              <i class="fas fa-table"></i>
              Balanço</div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr align="center">
                      <th>Valor das Despesas</th>
                      <th>Valor dos Recebimentos</th>
                      <th>Saldo</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr align="center">
                      <th>Valor das Despesas</th>
                      <th>Valor dos Recebimentos</th>
                      <th>Saldo</th>
                    </tr>
                  </tfoot>
                  <tbody>
                      <tr align="center">
                        <td> <?= htmlspecialchars(number_format($data['despesas'] ?? 0, 2)) ?> </td>
                        <td> <?= htmlspecialchars(number_format($data['recebimentos'] ?? 0, 2)) ?> </td>
                        <td> <?= htmlspecialchars(number_format($data['saldo'] ?? 0, 2)) ?> </td>
                      </tr>
                  </tbody>
                  
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- /.content-wrapper -->
<?php include_once __DIR__ . '/_common/Footer.php' ?>
