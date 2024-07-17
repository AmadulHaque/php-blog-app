<?php

namespace App\Console\Commands;

class MakeMigration {
    public function handle($args) {
        $migrationName = $args[0] ?? null;

        if (!$migrationName) {
            echo "Please provide a migration name.\n";
            return;
        }

        $timestamp = date('Y_m_d_His');
        $className = $this->convertToClassName($migrationName);
        $fileName = "{$timestamp}_{$migrationName}.php";
        $directoryPath = __DIR__ . "/../../../database/migrations";
        $filePath = "{$directoryPath}/{$fileName}";

        // Create the migrations directory if it doesn't exist
        if (!is_dir($directoryPath)) {
            if (!mkdir($directoryPath, 0777, true)) {
                echo "Failed to create migrations directory.\n";
                return;
            }
        }

        $stubPath = __DIR__ . '/stubs/migration.stub';

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
            [$className, $this->convertToTableName($migrationName)],
            $stubContent
        );

        if (file_put_contents($filePath, $migrationContent) === true) {
            echo "Failed to write migration file: {$filePath}\n";
            return;
        }

        echo "Migration {$fileName} created successfully.\n";
    }

    protected function convertToClassName($migrationName) {
        return 'Create' . str_replace(' ', '', ucwords(str_replace('_', ' ', $migrationName))) . 'Table';
    }

    protected function convertToTableName($migrationName) {
        return strtolower(str_replace(' ', '_', $migrationName));
    }
}
