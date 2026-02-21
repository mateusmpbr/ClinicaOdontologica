<?php
session_start();
// simulate logged-in funcionario
$_SESSION["funcionario"] = 1;
// set GET id
$_GET['id'] = 1;
// change dir to the file's dir so relative includes work
chdir(__DIR__ . '/../system/recepcionista/editar');
ob_start();
require 'editar-paciente.php';
$h = ob_get_clean();
// print only the select and the submit button lines
if (preg_match('/<select[^>]*id="select-paciente".*?<\/select>/s', $h, $m)) echo $m[0] . "\n";
if (preg_match('/<button[^>]*>\s*Atualizar\s*<\/button>/s', $h, $b)) echo $b[0] . "\n";
?>