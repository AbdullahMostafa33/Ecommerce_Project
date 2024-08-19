<?php

namespace App\Traits;

use App\Models\User;

trait mainTrait
{
    public function getAdmin()
    {
        $emails = ['abdullahayana80@gmail.com',];

        $admins = User::whereIn('email', $emails)->get();  
        
        return $admins; 
    }
}
