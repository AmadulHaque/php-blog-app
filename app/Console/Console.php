<?php

namespace App\Console;

class Console
{
    protected $commands = [
        'make:controller'   => \App\Console\Commands\MakeController::class,
        'make:model'        => \App\Console\Commands\MakeModel::class,
        'make:migration'    => \App\Console\Commands\MakeMigration::class,
        'migrate'           => \App\Console\Commands\Migrate::class,
        'serve'             => \App\Console\Commands\Serve::class,
        'db:seed'           => \App\Console\Commands\Seeder::class,
        'test'              => \App\Console\Commands\Test::class,
    ];

    public function run($argv)
    {
        array_shift($argv);
        $commandName = array_shift($argv);

        if (isset($this->commands[$commandName])) {
            $command = new $this->commands[$commandName]();
            $command->handle($argv);
        } else {
            echo "Command not found.\n";
        }
    }
}
