<?php
// Composer autoload + application bootstrap
// Require vendor autoload if available; tolerate missing vendor during edit time.
$composerAutoload = __DIR__ . '/../vendor/autoload.php';
if (file_exists($composerAutoload)) {
    require_once $composerAutoload;
}

// Load config/database (Database class) and helper functions
$configDb = __DIR__ . '/../config/database.php';
if (file_exists($configDb)) {
    require_once $configDb;
}

$funcoes = __DIR__ . '/Helpers/funcoesAuxiliares.php';
if (file_exists($funcoes)) {
    require_once $funcoes;
}

// Backwards compatibility: map old global class names to namespaced App\Models classes
$aliases = [
    'Administrador' => \App\Models\Administrador::class,
    'Auxiliar' => \App\Models\Auxiliar::class,
    'Auxiliar_auxilia_Dentista' => \App\Models\AuxiliarAuxiliaDentista::class,
    'Dentista' => \App\Models\Dentista::class,
    'Despesa' => \App\Models\Despesa::class,
    'Especialidade' => \App\Models\Especialidade::class,
    'Funcionario' => \App\Models\Funcionario::class,
    'Paciente' => \App\Models\Paciente::class,
    'PlanoDentario' => \App\Models\PlanoDentario::class,
    'Recebimento' => \App\Models\Recebimento::class,
    'Recepcionista' => \App\Models\Recepcionista::class,
    'Dentista_consulta_Paciente' => \App\Models\DentistaConsultaPaciente::class,
    'Dentista_has_Especialidade' => \App\Models\DentistaHasEspecialidade::class,
    'Balanco' => \App\Models\Balanco::class,
];

foreach ($aliases as $old => $new) {
    if (class_exists($new) && !class_exists($old)) {
        class_alias($new, $old);
    }
}

// You can add global bootstrap code here (error handlers, config, etc.)

?>
