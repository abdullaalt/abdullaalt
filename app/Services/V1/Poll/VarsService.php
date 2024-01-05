<?php
namespace App\Services\V1\Poll;

use Response;
use Errors;

//use App\Services\V1\Poll\PollsService;

use App\Models\V1\Wall\WallVar;
use App\Models\V1\Wall\WallVarsVote;

class VarsService extends PollsService{

    private $post;

    public function getVar($var_id){

        $this->checkDataConditions(WallVar::find($var_id), 'VAR_NOT_FOUND');
        
        return $this;

    }

    public function getVarPost($var_id = false){

        if ($var_id){
            $var_id = !$var_id ? $this->get('id') : $var_id;
            $var = WallVar::find($var_id);
        }else{
            $var = $this->get();
        }
        
        $this->post = (new PollsService())->getPost($var->post_id);
        return $this;

    }

    public function post(){
        return $this->post;
    }

    public function isVoted($var_id, $user_id){
        return WallVarsVote::isVoted($var_id, $user_id);
    }

    public function incrementVotes($var_id = false){

        $var_id = !$var_id ? $this->get('id') : $var_id;

        $count = WallVarsVote::addVote($var_id, auth()->id(), $this->post()->get('id'));
        $this->addProperty('votes', $count);
        $this->post()->addProperty('is_voted', true);

        return $this;

    }

    public function decrementVotes($var_id = false){

        $var_id = !$var_id ? $this->get('id') : $var_id;

        $count = WallVarsVote::removeVote($var_id, auth()->id(), $this->post()->get('id'));
        $this->addProperty('votes', $count);
        $this->post()->addProperty('is_voted', false);

        return $this;

    }

    public function saveData($array = false){

        $this->save(WallVar::class, $array);

    }

    public function alreadyVoted(){
        $this->setResponse(new Response((new Errors(
            [Response::getLangValue('ALREADY_VOTED')]
        ))->getErrors(), 403));

        return $this;
    }

    public function didntVoted(){
        $this->setResponse(new Response((new Errors(
            [Response::getLangValue('DIDNT_VOTED')]
        ))->getErrors(), 403));

        return $this;
    }

}