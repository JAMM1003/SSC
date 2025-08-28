<?php
declare(strict_types=1);
$config = require dirname(__DIR__) . '/config/config.php';
try {
    $db = $config['db'];
    $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s', $db['host'], $db['port'], $db['name'], $db['charset']);
    $pdo = new PDO($dsn, $db['user'], $db['pass'], [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    echo 'OK PDO ' . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
} catch (Throwable $e) {
    http_response_code(500);
    echo 'ERROR: ' . htmlspecialchars($e->getMessage());
}

