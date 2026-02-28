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

// Configure session cookie flags before any session_start() calls in helpers
$appEnv = getenv('APP_ENV') ?: ($_SERVER['APP_ENV'] ?? 'production');
$isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
// Configure session settings only when a session is not already active
if (session_status() === PHP_SESSION_NONE) {
    // Ensure sensible ini settings
    ini_set('session.cookie_secure', $isSecure ? '1' : '0');
    ini_set('session.cookie_httponly', '1');
    // Prefer SameSite via session_set_cookie_params when available (PHP 7.3+ supports array)
    $cookieParams = session_get_cookie_params();
    if (PHP_VERSION_ID >= 70300) {
        session_set_cookie_params([
            'lifetime' => $cookieParams['lifetime'] ?? 0,
            'path' => $cookieParams['path'] ?? '/',
            'domain' => $cookieParams['domain'] ?? '',
            'secure' => $isSecure,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
    } else {
        // Fallback for older PHP: append SameSite to path
        $path = ($cookieParams['path'] ?? '/') . '; SameSite=Lax';
        session_set_cookie_params($cookieParams['lifetime'] ?? 0, $path, $cookieParams['domain'] ?? '', $isSecure, true);
    }
} else {
    error_log('Session already active when bootstrap ran; skipping session cookie/ini reconfiguration');
}

// Disable error display in non-development environments
if (strtolower($appEnv) === 'development') {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
}

$funcoes = __DIR__ . '/Helpers/Utils.php';
if (file_exists($funcoes)) {
    require_once $funcoes;
}

// Backwards compatibility: map old global class names to namespaced App\Models classes
$aliases = [
    'Administrador' => \ClinicaOdontologica\Models\Administrador::class,
    'Auxiliar' => \ClinicaOdontologica\Models\Auxiliar::class,
    'Auxiliar_auxilia_Dentista' => \ClinicaOdontologica\Models\AuxiliarAuxiliaDentista::class,
    'Dentista' => \ClinicaOdontologica\Models\Dentista::class,
    'Despesa' => \ClinicaOdontologica\Models\Despesa::class,
    'Especialidade' => \ClinicaOdontologica\Models\Especialidade::class,
    'Funcionario' => \ClinicaOdontologica\Models\Funcionario::class,
    'Paciente' => \ClinicaOdontologica\Models\Paciente::class,
    'PlanoDentario' => \ClinicaOdontologica\Models\PlanoDentario::class,
    'Recebimento' => \ClinicaOdontologica\Models\Recebimento::class,
    'Recepcionista' => \ClinicaOdontologica\Models\Recepcionista::class,
    'Dentista_consulta_Paciente' => \ClinicaOdontologica\Models\DentistaConsultaPaciente::class,
    'Dentista_has_Especialidade' => \ClinicaOdontologica\Models\DentistaHasEspecialidade::class,
    'Balanco' => \ClinicaOdontologica\Models\Balanco::class,
];

foreach ($aliases as $old => $new) {
    if (class_exists($new) && !class_exists($old)) {
        class_alias($new, $old);
    }
}

// You can add global bootstrap code here (error handlers, config, etc.)
// PSR-3 logger (Monolog) — create a shared logger if available
$logger = null;
if (class_exists(\Monolog\Logger::class)) {
    $logDir = __DIR__ . '/../storage/logs';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0775, true);
    }
    $logPath = $logDir . '/app.log';
    $logger = new \Monolog\Logger('clinica');
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($logPath, \Monolog\Logger::DEBUG));
    // Expose a simple accessor
    function logger(): \Psr\Log\LoggerInterface
    {
        global $logger;
        return $logger;
    }
}
// PSR-7 ServerRequest (Nyholm) — create a shared ServerRequest from globals
$request = null;
if (class_exists(\Nyholm\Psr7Server\ServerRequestCreator::class)) {
    $psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();
    $creator = new \Nyholm\Psr7Server\ServerRequestCreator(
        $psr17Factory,
        $psr17Factory,
        $psr17Factory,
        $psr17Factory
    );
    $request = $creator->fromGlobals();

    function request(): \Psr\Http\Message\ServerRequestInterface
    {
        global $request;
        return $request;
    }
}
