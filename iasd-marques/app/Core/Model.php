<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

class Model
{
    protected PDO $pdo;

    public function __construct(array $config)
    {
        $db = $config['db'];
        $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $db['host'], $db['port'], $db['name'], $db['charset']
        );
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            $this->pdo = new PDO($dsn, $db['user'], $db['pass'], $options);
        } catch (PDOException $e) {
            error_log('DB connection error: ' . $e->getMessage());
            exit('Error de conexión a la base de datos.');
        }
    }
}

