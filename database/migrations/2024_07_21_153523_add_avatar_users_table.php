<?php

use App\Core\Migration;

return new class extends Migration {
    public $table = 'users';
    public $status = 'exists'; 

    public function up() {
      $sql = "ALTER  TABLE $this->table  ADD COLUMN date_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ";
        $this->pdo->exec($sql);
    }

    public function down() {
        $sql = "ALTER TABLE $this->table DROP COLUMN date_time";
        $this->pdo->exec($sql);
    }
};
