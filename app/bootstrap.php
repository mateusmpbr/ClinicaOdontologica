<?php
// Composer autoload + application bootstrap
// Require vendor autoload if available; tolerate missing vendor during edit time.
$composerAutoload = __DIR__ . '/../vendor/autoload.php';
if (file_exists($composerAutoload)) {
    require_once $composerAutoload;
}

// Load helper functions (non-class code)
$funcoes = __DIR__ . '/Helpers/funcoesAuxiliares.php';
if (file_exists($funcoes)) {
    require_once $funcoes;
}

// You can add global bootstrap code here (error handlers, config, etc.)

?>
