<?php

session_start();
$_SESSION["funcionario"] = 1;
$_GET['id'] = 1;
chdir(__DIR__ . '/../system/recepcionista/editar');
ob_start();
require 'editar-paciente.php';
$h = ob_get_clean();
echo $h;
