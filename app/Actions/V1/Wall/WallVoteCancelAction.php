<?php
namespace App\Actions\V1\Wall;

use App\Contracts\Wall\WallVoteCancelActionContract;
use App\Services\V1\Poll\VarsService;

class WallVoteCancelAction implements WallVoteCancelActionContract{
 
    public function __invoke($var_id) {

        $var = new VarsService();
        $var->getVar($var_id);

        if ($var->response()->isFail()){
            return $var->response()->json();
        }
        
        $var->getVarPost()
                    ->post()
                    ->setUser(auth()->id())
                    ->isAccessToPost()
                    ->addProperty('is_voted', $var->isVoted($var_id, auth()->id()));
        
        if ($var->post()->response()->isFail()){
            return $var->post()->response()->json();
        }

        if ($var->post()->get('is_voted')){
            $var->decrementVotes()->saveData(['votes']);
        }else{
            return $var->didntVoted()->response()->json();
        }

        return [
            'is_voted' => $var->post()->get('is_voted'),
            'votes' => $var->getPoll($var->get('post_id'))
        ];

    }

}