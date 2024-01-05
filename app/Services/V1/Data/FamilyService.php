<?php
namespace App\Services\V1\Data;

use Response;
use Errors;

use App\Services\V1\Data\NodeService;

use App\Http\Resources\V1\Data\NodeResource;

class FamilyService extends NodeService{

    private $family;
    private $current_node;
    private $params = ['father', 'mather', 'childs', 'siblings', 'spouce'];

    public function buildFamily($node_id, $params = false){

        if (!$node_id || $node_id < 1){
            $this->setResponse(new Response((new Errors(
                [Response::getLangValue('INVALID_NODE_ID')]
            ))->getErrors(), 404)); 
        }

        $current_node = (new NodeService())->getNode($node_id);
        
        if ($current_node->response()->isFail()){
            $this->setResponse(new Response((new Errors(
                [Response::getLangValue('NODE_NOT_FOUND')]
            ))->getErrors(), 404)); 
        }

        if ($params){
            $this->setParams($params);
        }

        $current_node->addProperty('links', $current_node->getLinks($node_id));
        
        $this->setCurrentNode($current_node);
        
        $this->setResponse(new Response([], 200));
        foreach ($this->params as $param){
            if (method_exists($this, 'getNode'.ucfirst($param)))
                $this->family[$param] = call_user_func([$this, 'getNode'.ucfirst($param)], false);
        }
        $this->family = (object)$this->family;
        $this->setData($this->family);
        
        return $this;

    }

    public function isInFamily($node_id1, $node_id2){
        if ($node_id1 < 1 || $node_id2 < 1){
            return false;
        }

        $node1 = $this->buildFamily($node_id1);
        
        $persons = $node1->executeFamilyIds();
        
        return in_array($node_id2, $persons);
    }

    public function executeFamilyIds(){
        $ids = [];
        $persons = $this->getFamilyPersons();
        
        foreach ($persons as $key => $node) {
            if ($node->id)
                $ids[] = $node->id;
        }
        return $ids;
    }

    public function getFamilyPersons(){

        $result = [];

        foreach ($this->params as $param){
            if (isset($this->family->{$param})){
                if ($param == 'mather' || $param == 'father')
                    $result[] = $this->family->{$param};
                else
                $result = array_merge($result, $this->family->{$param});
            }
        }

        return $result;

    }

    public function setCurrentNode($node){
        $this->current_node = $node;
    }

    public function setParams($params){
        $this->params = $params;
    }

    public function getNodeFather($father_id = false){
        
        $father_id = $father_id ? $father_id : $this->current_node->get('links.f_id');
        
        return $this->addFamilyNode($father_id);

    }

    public function getNodeMather($mather_id = false){
        
        $mather_id = $mather_id ? $mather_id : $this->current_node->get('links.m_id');

        return $this->addFamilyNode($mather_id);

    }

    public function getNodeChilds($node_id){
        
        $node_id = $node_id ? $node_id : $this->current_node->get('id');

        $childs = $this->getChilds($node_id);
        $result = [];
        foreach ($childs as $child){
            $node = new NodeService();
            $node->setResponse(new Response([], 200))->setData($child);
            $result[] = $this->preparingFamilyNode($node);
        }

        return count($result) > 0 ? $result : null;

    }

    public function getNodeSiblings($node_id){

        $siblings = $this->getSiblings($this->current_node->get('f_id'), $this->current_node->get('m_id'));
        $result = [];
        foreach ($siblings as $sibling){
            $node = new NodeService();
            $node->setResponse(new Response([], 200))->setData($sibling);
            $result[] = $this->preparingFamilyNode($node);
        }

        return count($result) > 0 ? $result : null;

    }

    protected function addFamilyNode($node_id){
        $node = (new NodeService())->getNode($node_id);

        if ($node->response()->isFail()){
            return null;
        }
        
        $node->addProperty('links', $node->getLinks($node_id));

        return $this->preparingFamilyNode($node);
    }

    protected function preparingFamilyNode($node){
        return $node->addDataToResponse(NodeResource::class)
                    ->response()
                    ->json()->original;
    }

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

        $data = $this->buildFamily($node_id);
        
        if ($data->response()->isFail()){
            return false;
        }
        
        return $data->get();
    }

}