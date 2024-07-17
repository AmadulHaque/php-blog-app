<?php

namespace App\Models;

use PDO;

class BaseModel
{
    protected static $pdo;

    public function __construct()
    {
        if (!self::$pdo) {
            self::initializePDO();
        }
    }

    protected static function initializePDO()
    {
        $config = require __DIR__ . '/../../config/database.php';
        $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";
        self::$pdo = new PDO($dsn, $config['username'], $config['password']);
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected static function getPDO()
    {
        if (!self::$pdo) {
            self::initializePDO();
        }
        return self::$pdo;
    }

    public static function query($sql, $params = [])
    {
        $stmt = self::getPDO()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
