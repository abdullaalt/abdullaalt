<?php
namespace App\Services\V1\Users;

use App\Models\V1\User\Centrifuge;

class CentrifugeService{

    private string $cent_token;
    private string $channel;

    function __construct($user_id){

        $data = Centrifuge::getUserData($user_id);

        $this->cent_token = $data->token;
        $this->channel = $data->channel;

    }

    public function getToken(){
        return $this->cent_token;
    }

    public function getChannel(){
        return $this->channel;
    }

}