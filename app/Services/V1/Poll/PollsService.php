<?php
namespace App\Services\V1\Poll;

use Response;
use Errors;

use App\Services\V1\Wall\WallPostService;

use App\Models\V1\Wall\WallVar;
use App\Models\V1\Wall\WallVarsVote;

class PollsService extends WallPostService{

    public function __construct(){
        
    }

    public function getPoll($source_id, $source='wall'){

        $vars = WallVar::getPoll($source_id, $source);

        if (count($vars) < 1)
            return null;

        $result['vars'] = $vars;
        $result['total'] = 0;
        foreach ($result['vars'] as $key => $var) {
            $result['total'] += $var->votes;
        }

        return $result;

    }
    
    public function addPoll($votes, $post_id){
        
        foreach ($votes as $key => $value) {
            WallVar::addVar([
                'title' => $value,
                'post_id' => $post_id
            ]);
        }

        return true;

    }

    public function deleteVarsByIds($ids){
        foreach ($ids as $key => $value) {
            WallVar::deleteVar($value);
            WallVarsVote::deleteVarVotes($value);
        }
    }

}