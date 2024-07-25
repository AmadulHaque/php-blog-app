<?php

use App\Core\Migration;

return new class extends Migration {
    public $table = 'users';
    public $status = 'create';

    public function up() {
        $sql = "CREATE TABLE $this->table (
            id INT AUTO_INCREMENT PRIMARY KEY,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->pdo->exec($sql);
    }

    public function down() {
        $sql = "DROP TABLE IF EXISTS $this->table";
        $this->pdo->exec($sql);
    }
};
