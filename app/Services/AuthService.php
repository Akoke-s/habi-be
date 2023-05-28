<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class AuthService {

    /* create a new user account
    * @param App\Http\Requests\RegisterUserRequest|obj $userDetails
    * @return \Illuminate\Auth\Access\Response|bool
    */
    public function create_user(obj $userDetails)
    {
        return DB::transaction(function() use ($userDetails) {
            
        });
    }
}