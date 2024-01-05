<?php
namespace App\Services\V1\Data;

use Response;
use Errors;

use App\Facades\TeipFacade;

class TeipsService extends TeipFacade{

    public function getTeip($teip_id){

        $data = $this->loadTeip($teip_id);

        if ($data){
            $this->setData($data);
            $this->setResponse(new Response([], 200));
        }else{
            $this->setResponse(new Response((new Errors(
                [Response::getLangValue('TEIP_NOT_FOUND')]
            ))->getErrors(), 404));
        }

        return $this;

    }

    public function checkCondition($teip_id){
        if (!$teip_id || $teip_id < 1){
            return false;
        }

        return true;
    }

    public function loadDataForForeight($teip_id){
        if (!$this->checkCondition($teip_id)){
            return [];
        }

        $data = $this->getTeip($teip_id);

        if ($data->response()->isFail()){
            return false;
        }

        return $data->get();
    }

}