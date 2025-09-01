<?php
declare(strict_types=1);

// Front controller

// Security headers
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');

// Autoload simple (PSR-4-like)
spl_autoload_register(function (string $class): void {
    $baseDir = dirname(__DIR__) . '/app/';
    $class = str_replace('\\', '/', $class);
    $paths = [
        $baseDir . $class . '.php',
        $baseDir . 'Core/' . basename($class) . '.php',
        $baseDir . 'Controllers/' . basename($class) . '.php',
        $baseDir . 'Models/' . basename($class) . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

$config = require dirname(__DIR__) . '/config/config.php';

// Sessions
session_name($config['app']['session_name'] ?? 'iasd_session');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Lax',
]);
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Ensure at least one admin exists (bootstrap on first run)
try {
    $uModel = new App\Models\Usuario($config);
    if ($uModel->countUsers() === 0) {
        $uModel->createUser('Administrador', 'admin@demo.local', 'Admin123!', 'admin');
        error_log('Usuario admin creado: admin@demo.local / Admin123!');
    }
} catch (\Throwable $e) {
    // ignore bootstrap errors if DB not ready yet
}

// Initialize CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\AsistentesController;
use App\Controllers\EventosController;
use App\Controllers\MensajesController;

// Routing
$basePath = rtrim($config['app']['base_url'] ?? '/iasd-marques/public', '/');
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';

// normalize
if ($basePath !== '' && str_starts_with($requestUri, $basePath)) {
    $path = substr($requestUri, strlen($basePath));
} else {
    $path = $requestUri;
}
$path = strtok($path, '?');
if ($path === false) { $path = '/'; }

// Public assets bypass
if (preg_match('#^/(css|js|img|vendor)/#', $path)) {
    return false; // Let Apache serve static files
}

// Define routes
switch ($path) {
    case '/':
        (new AuthController($config))->redirectHome();
        break;
    case '/login':
        (new AuthController($config))->login();
        break;
    case '/logout':
        (new AuthController($config))->logout();
        break;
    case '/forgot':
        (new AuthController($config))->forgot();
        break;

    case '/dashboard':
        (new DashboardController($config))->index();
        break;

    case '/asistentes':
        (new AsistentesController($config))->index();
        break;
    case '/asistentes/create':
        (new AsistentesController($config))->create();
        break;
    default:
        if (preg_match('#^/asistentes/edit/(\d+)$#', $path, $m)) {
            (new AsistentesController($config))->edit((int)$m[1]);
            break;
        }
        if (preg_match('#^/eventos$#', $path)) {
            (new EventosController($config))->index();
            break;
        }
        if (preg_match('#^/eventos/create$#', $path)) {
            (new EventosController($config))->create();
            break;
        }
        if (preg_match('#^/eventos/asistencia/(\d+)$#', $path, $m)) {
            (new EventosController($config))->asistencia((int)$m[1]);
            break;
        }
        if (preg_match('#^/eventos/exportar/(\d+)$#', $path, $m)) {
            (new EventosController($config))->exportarCsv((int)$m[1]);
            break;
        }
        if (preg_match('#^/mensajes/plantillas$#', $path)) {
            (new MensajesController($config))->plantillas();
            break;
        }
        if (preg_match('#^/mensajes/cola$#', $path)) {
            (new MensajesController($config))->cola();
            break;
        }
        if (preg_match('#^/mensajes/cola/procesar$#', $path)) {
            (new MensajesController($config))->procesarCola();
            break;
        }
        http_response_code(404);
        echo '404 - Página no encontrada';
}

