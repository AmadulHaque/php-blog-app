<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Route extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'router';
    }


}
