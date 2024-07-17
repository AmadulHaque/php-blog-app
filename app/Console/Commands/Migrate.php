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
                require_once $file;

                $className = $this->getClassNameFromFile($file);

                if ($className === null) {
                    echo "Class not found in file: {$file}\n";
                    continue;
                }

                $migration = new $className($pdo);

                if (method_exists($migration, 'up')) {
                    $table = strtolower($className);
                    if (!$this->tableExists($pdo, $table)) {
                        $migration->up();
                        echo "Migrated: {$className}\n";
                        echo "All migrations successfully applied.\n";
                    } else {
                        $migration->up();
                        echo "Table '{$table}' already exists. Skipping migration: {$className}\n";
                    }
                } else {
                    echo "Method 'up' does not exist in {$className}\n";
                }
            }

        } catch (\Exception $e) {
            echo "Migration failed: " . $e->getMessage() . "\n";
        }
    }

    /**
     * Extracts the class name from a PHP file.
     *
     * @param string $file The file path
     * @return string|null The class name or null if not found
     */
    private function getClassNameFromFile($file) {
        $content = file_get_contents($file);
        $namespace = '';
        $className = '';

        // Get namespace if it exists
        if (preg_match('/namespace\s+(.*?);/s', $content, $matches)) {
            $namespace = trim($matches[1]);
        }

        // Get class name if it exists
        if (preg_match('/class\s+(\w+)/', $content, $matches)) {
            $className = $matches[1];
        }

        // If namespace exists, prepend it to class name
        if ($namespace && $className) {
            return $namespace . '\\' . $className;
        } elseif ($className) {
            return $className;
        }

        return null;
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
