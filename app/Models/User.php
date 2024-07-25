<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected $table = 'users';


    public  function get()
    {
       $sql = "SELECT * FROM {$this->table};"; 
       return $this->query($sql);
    }



    
}
