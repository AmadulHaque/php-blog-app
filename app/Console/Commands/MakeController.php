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

        $controllerTemplate = "<?php

namespace App\Controllers\\" . str_replace('/', '\\', $controllerName) . ";

class " . basename($controllerName) . " {
    public function index() {
        echo 'This is the " . basename($controllerName) . " controller index method.';
    }
}
";

        file_put_contents($controllerPath, $controllerTemplate);
        echo "Controller {$controllerName} created successfully.\n";
    }
}
?>
