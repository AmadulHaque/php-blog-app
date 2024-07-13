<?php

namespace App\Console\Commands;

class Serve {
    public function handle($args) {
        $host = $args[0] ?? '127.0.0.1';
        $port = $args[1] ?? '8000';
        
        $command = sprintf('php -S %s:%s -t public', $host, $port);
        echo "Starting server on http://{$host}:{$port}\n";
        passthru($command);
    }
}
?>
