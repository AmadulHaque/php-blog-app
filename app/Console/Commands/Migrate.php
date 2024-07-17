<?php

namespace App\Console\Commands;

use Illuminate\Database\Capsule\Manager as Capsule;

class Migrate {
    public function handle()
    {
        try {
            $migrationFiles = glob(__DIR__ . '/../../../database/migrations/*.php');

            foreach ($migrationFiles as $file) {
                require_once $file;


                $className = $this->getClassNameFromFile($file);

             

                if ($className) {
                    // Instantiate the migration class
                    $migration = new $className();

                    // Ensure it's an instance of Laravel's Migration class
                    if (!($migration instanceof \Illuminate\Database\Migrations\Migration)) {
                        throw new \Exception("Invalid migration class: {$className}. It must implement Illuminate\Database\Migrations\Migration interface.");
                    }


                    // Run the migration
                    $migration->up();


                    echo "Migrated: {$className}\n";
                }

            }

            echo "All migrations successfully applied.\n";
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
    private function getClassNameFromFile($file)
    {
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


}

