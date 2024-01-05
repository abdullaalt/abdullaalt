<?php
namespace App\Models\V1\User;

use Illuminate\Database\Eloquent\Model;

class Centrifuge extends Model
{

    protected $table = 'centrifuge';

    protected $fillable = [
        'user_id',
        'token',
        'channel',
        'source'
    ];
    
    static function getUserData($user_id){

        return self::where('user_id', $user_id)->first();

    }

}