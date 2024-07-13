<?php

namespace App\Core;

class Console {
    protected $commands = [];

    public function __construct() {
        // Register your commands here
        $this->commands = [
            'make:controller' => \App\Console\Commands\MakeController::class,
            'serve' => \App\Console\Commands\Serve::class,
            // Add more commands here
        ];
    }

    public function run($argv) {
        $commandName = $argv[1] ?? null;

        if ($commandName && isset($this->commands[$commandName])) {
            $command = new $this->commands[$commandName]();
            $command->handle(array_slice($argv, 2));
        } else {
            $this->showHelp();
        }
    }

    protected function showHelp() {
        echo "Available commands:\n";
        foreach ($this->commands as $command => $handler) {
            echo "  $command\n";
        }
    }
}
?>
