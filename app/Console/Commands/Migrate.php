<?php

namespace App\Console\Commands;

use App\Core\Database;

class Migrate  {
    public function handle($arguments) {
        try {
            $database = new Database();
            $pdo = $database->getConnection();
            $migrationFiles = glob(__DIR__ . '/../../../database/migrations/*.php');

            foreach ($migrationFiles as $file) {
                $obj =  require_once $file;

                $table = $obj->table;

                if (!$this->tableExists($pdo, $table)) {
                    if ($obj->status=='create') {
                        $obj->up();
                        echo "Migrated: {$table} All migrations successfully applied \n";
                    }
                } else {
                    if ($obj->status=='exists') {
                        $obj->up();
                        echo "Migrated: {$table} All migrations successfully applied \n";
                    }
                }
            }

        } catch (\Exception $e) {
            echo "Migration failed: " . $e->getMessage() . "\n";
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
