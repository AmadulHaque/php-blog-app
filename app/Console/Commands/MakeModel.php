<?php

namespace App\Console\Commands;


class MakeModel
{
    public function handle($arguments)
    {
        if (empty($arguments)) {
            echo "Please provide the model name.\n";
            return;
        }

        $modelName = ucfirst($arguments[0]);
        $modelTemplate = file_get_contents(__DIR__ . '/stubs/model.stub');
        $modelTemplate = str_replace('{{modelName}}', $modelName, $modelTemplate);

        file_put_contents(__DIR__ . "/../../models/{$modelName}.php", $modelTemplate);
        echo "Model {$modelName} created successfully.\n";
    }
}
