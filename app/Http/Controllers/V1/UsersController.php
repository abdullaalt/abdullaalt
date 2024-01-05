<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;


use App\Contracts\Users\UserActionContract;
use App\Contracts\Users\UserInfoActionContract;

//use App\Http\Requests\RulesRequest;

//use App\Models\instConProf;

class UsersController extends Controller {

    public function getUserByToken(UserActionContract $UserActionContract){
       
        return $UserActionContract();

    }

    public function getUserById($user_id, UserInfoActionContract $UserInfoActionContract){
        return $UserInfoActionContract($user_id);
    }

}