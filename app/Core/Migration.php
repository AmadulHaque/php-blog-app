<?php
namespace App\Core;

use App\Core\Database;

abstract class Migration {
    protected $pdo;

    public function __construct() {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    abstract public function up();
    abstract public function down();
}
