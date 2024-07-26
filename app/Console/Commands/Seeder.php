<?php

namespace App\Console\Commands;

use App\Core\Database;

class Seeder  {
    public function handle($arguments) {
        try {
            $database = new Database();
            $pdo = $database->getConnection();
            $migrationFiles = glob(__DIR__ . '/../../../database/seeder/*.php');

            foreach ($migrationFiles as $file) {
                $obj =  require_once $file;

                $table = $obj->table;

                if ($this->tableExists($pdo, $table)) {
                    $obj->run();
                    echo "Seed: {$table} successfully applied \n";
                } else {
                    echo "Seed: {$table} exist not found \n";
                }
            }

        } catch (\Exception $e) {
            echo "Seeder failed: " . $e->getMessage() . "\n";
        }
    }

    /**
     * Checks if a table exists in the database.
     *
     * @param \PDO $pdo The PDO instance
     * @param string $table The table name
     * @return bool True if the table exists, false otherwise
    */
    private function tableExists($pdo, $table) {
        try {
            $result = $pdo->query("SELECT 1 FROM {$table} LIMIT 1");
            return $result !== false;
        } catch (\Exception $e) {
            return false;
        }
    }
}
