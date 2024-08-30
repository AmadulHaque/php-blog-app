<?php

namespace App\Console\Commands;

class Test
{
    public function handle($args)
    {
        // Base path to the vendor directory relative to this script's directory
        $vendorPath = __DIR__ . '/../../../vendor';

        // Determine the correct path to PHPUnit based on the operating system
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $phpunitPath = $vendorPath . '\bin\phpunit.bat'; // Use .bat for Windows
        } else {
            $phpunitPath = $vendorPath . '/bin/phpunit'; // Use standard path for Unix-like systems
        }

        // Add any arguments passed to the command
        if (!empty($args)) {
            $phpunitPath .= ' ' . implode(' ', $args);
        }

        // Execute the PHPUnit command
        exec($phpunitPath, $output, $returnVar);

        // Output the results
        foreach ($output as $line) {
            echo $line . PHP_EOL;
        }

        // Check if the command was successful
        if ($returnVar !== 0) {
            echo "Tests failed with exit code $returnVar." . PHP_EOL;
        } else {
            echo "All tests passed." . PHP_EOL;
        }
    }
}


