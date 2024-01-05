<?php
namespace App\Services\V1\Notifications;

use Response;
use Errors;

class NotificationsService{

    private $addressees;

    public function __construct($addressees){
        if ($addressees)
            $this->addressees = $addressees;
    }

    public function send(){
        return true;
    }

}