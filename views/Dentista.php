<?php
require_once __DIR__ . '/../app/bootstrap.php';
use ClinicaOdontologica\Controllers\DentistaController;
$controller = new DentistaController();
$data = $controller->handleRequest();
include_once __DIR__ . '/_common/Header.php';

?>
  <body class="bg-dark">
    <div id="wrapper">
      <div id="content-wrapper">
        <div class="container-fluid">

          <!-- DataTables Example -->
          <div class="card mb-3">

            <div class="card-header">
              <i class="fas fa-table"></i>
              Dentistas
            <div class="float-right">
              <a href="_common/ConsultaEspecialidade.php" target="_blank" class="btn">Buscar especialidades</a>
            </div>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr align="center">
                      <th>Nome</th>
                      <th>CRO</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr align="center">
                      <th>Nome</th>
                      <th>CRO</th>
                    </tr>
                  </tfoot>
                  <tbody>
                      <?php foreach ($data['dentistas'] as $row) { ?>
                      <tr align="center">
                        <td> <?= htmlspecialchars($row->nome); ?> </td>
                        <td> <?= htmlspecialchars($row->cro); ?></td>
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
    </div>
    <!-- /#wrapper -->
    <!-- Bootstrap core JavaScript-->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugin JavaScript-->
    <script src="/vendor/chart.js/Chart.min.js"></script>
    <script src="/vendor/datatables/jquery.dataTables.js"></script>
    <script src="/vendor/datatables/dataTables.bootstrap4.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/js/sb-admin.min.js"></script>

    <!-- Demo scripts for this page-->
    <script src="/js/datatables.js"></script>
    

  </body>

</html>
