<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

if (!function_exists('base_path')) {
    function base_path($path = '') {
        return __DIR__ . '/../../' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

class RouteServiceProvider extends ServiceProvider
{
    protected $router;

    public function __construct($app)
    {
        parent::__construct($app);
        $this->router = $app['router'];
    }

    public function boot()
    {
        $this->mapWebRoutes($this->router);
    }

    protected function mapWebRoutes(Router $router)
    {
        require base_path('routes/app.php');
    }
}
