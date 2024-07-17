<?php

namespace App\Console\Commands;

use App\Core\Database;

class MakeMigration {

    public function handle($args) {

        $database = new Database();
        $pdo = $database->getConnection();

        $migrationName = $args[0] ?? null;

        if (!$migrationName) {
            echo "Please provide a migration name.\n";
            return;
        }

        $className = ucfirst($migrationName);
        $fileName = date('Y_m_d_His') . "_{$migrationName}.php";
        $directoryPath = __DIR__ . "/../../../database/migrations";
        $filePath = "{$directoryPath}/{$fileName}";

        // Create the migrations directory if it doesn't exist
        if (!is_dir($directoryPath)) {
            if (!mkdir($directoryPath, 0777, true)) {
                echo "Failed to create migrations directory.\n";
                return;
            }
        }

        if (!$this->tableExists($pdo, $migrationName)) {
            $stubPath = __DIR__ . '/stubs/migration.stub'; 
        } else {
            $stubPath = __DIR__ . '/stubs/migration_alert.stub';
        }

       
        if (!file_exists($stubPath)) {
            echo "Stub file does not exist: {$stubPath}\n";
            return;
        }

        $stubContent = file_get_contents($stubPath);

        if ($stubContent === false) {
            echo "Failed to read stub file: {$stubPath}\n";
            return;
        }

        $migrationContent = str_replace(
            ['{{className}}', '{{tableName}}'],
            [$className, $migrationName],
            $stubContent
        );

        if (file_put_contents($filePath, $migrationContent) === false) {
            echo "Failed to write migration file: {$filePath}\n";
            return;
        }

        echo "Migration {$fileName} created successfully.\n";
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


// implemment if table exits than  ALTER TABLE {{$tableName}}  else CREATE TABLE {{$tableName}} 