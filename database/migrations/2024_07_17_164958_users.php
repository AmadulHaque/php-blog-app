<?php


use App\Core\Migration;

class Users extends Migration {
    public function up() {
        $sql = "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->pdo->exec($sql);
    }

    public function down() {
        $sql = "DROP TABLE IF EXISTS users";
        $this->pdo->exec($sql);
    }
}
