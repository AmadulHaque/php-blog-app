<?php

namespace App\Controllers;

class HomeController {


    public function index() 
    {
        return view('app');
    }

    public function admin() 
    {
        return view('backend/master');
    }


}
