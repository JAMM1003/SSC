<?php
declare(strict_types=1);

// Copie este archivo desde config.example.php y ajuste las credenciales según su XAMPP
return [
    'db' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'name' => 'iasd_marques',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8mb4',
    ],
    'app' => [
        'base_url' => '/iasd-marques/public',
        'env' => 'local',
        'session_name' => 'iasd_session',
    ],
];

