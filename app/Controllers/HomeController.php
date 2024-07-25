<?php

namespace App\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController {


    public function index(Request $request) 
    {
        $users = (new User())->get();
        return view('app',['users'=>$users]);
    }

    public function admin() 
    {
        return view('backend/master');
    }


}
