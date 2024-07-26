<?php

use App\Core\Migration;

return new class extends Migration {
    public $table = 'categories';
    public $status = 'create';

    public function up() {
        $sql = "CREATE TABLE $this->table (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100),
            image VARCHAR(250),
            order_id INT,
            status ENUM('1', '0') DEFAULT '1' COMMENT '1=Active 0=InActive',  
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->pdo->exec($sql);
    }

    public function down() {
        $sql = "DROP TABLE IF EXISTS $this->table";
        $this->pdo->exec($sql);
    }
};
