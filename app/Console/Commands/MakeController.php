<?php

namespace App\Console\Commands;

class MakeController {
    public function handle($args) {
        $controllerName = $args[0] ?? null;

        if (!$controllerName) {
            echo "Please provide a controller name.\n";
            return;
        }

        $controllerPath = "app/Controllers/{$controllerName}.php";
        $directoryPath = dirname($controllerPath);

        // Create the directory if it doesn't exist
        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        $stubPath = __DIR__ . '/stubs/controller.stub';
        $stubContent = file_get_contents($stubPath);

        $controllerContent = str_replace(
            '{{controllerName}}',
            basename($controllerName),
            $stubContent
        );

        file_put_contents($controllerPath, $controllerContent);
        echo "Controller {$controllerName} created successfully.\n";
    }
}
