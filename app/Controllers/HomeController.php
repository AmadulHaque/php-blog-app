<?php

namespace App\Controllers;

use Illuminate\Http\Request;

class HomeController {


    public function index(Request $request) 
    {

        return view('app');
    }

    public function admin() 
    {
        return view('backend/master');
    }


}
