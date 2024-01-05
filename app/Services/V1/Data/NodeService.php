<?php
namespace App\Services\V1\Data;

use Response;
use Errors;

use App\Facades\DataFacade;

class NodeService extends DataFacade{

    // public function __construct($node_id = false){
    //     if ($node_id) $this->setDataId('node_id', $node_id);
    // }

    public function getNode($node_id){

        if (!$node_id || $node_id < 1){
            $this->setResponse(new Response((new Errors(
                [Response::getLangValue('INVALID_NODE_ID')]
            ))->getErrors(), 400)); 

            return $this;
        }

        $this->setDataId('node_id', $node_id);
        $data = $this->loadNode($this->node_id);

        if ($data){
            $this->setData($data);
            $this->setResponse(new Response([], 200));
        }else{
            $this->setResponse(new Response((new Errors(
                [Response::getLangValue('NODE_NOT_FOUND')]
            ))->getErrors(), 404));
        }

        return $this;

    }

    public function getLinks($node_id){
        return $this->loadLinks($node_id);
    }

    // public function save($data, $node_id = false){
    //     return true;
    // }

    public function checkCondition($node_id){
        if ($node_id < 1){
            return false;
        }

        return true;
    }

    public function loadDataForForeight($node_id){
        if (!$this->checkCondition($node_id)){
            return [];
        }

        $data = $this->getNode($node_id);

        if ($data->response()->isFail()){
            return false;
        }

        return $data->get();
    }

}