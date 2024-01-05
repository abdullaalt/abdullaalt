<?php

namespace App\Facades;

use App\Facades\MainFacade;
use Laravel\Ui\UiServiceProvider;
use RuntimeException;
use Response;
use Errors;


use App\Models\V1\Events\Event;
use App\Models\V1\Events\Reminder;
use App\Models\V1\Events\TreeSubscription;
use App\Models\V1\Data\Link;

class EventsFacade extends MainFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */

    private $model;
    private $subs;
    private $reminder;
    private $ancestors;

    public function init($node_id = false){

        if (!$node_id){
            return $this->notConnected();
        }

        $this->model = new Event();
        $this->reminder = new Reminder();
        $this->subs = new TreeSubscription();
        $this->setAncestors($node_id);
        return $this;

    }

    protected static function getFacadeAccessor()
    {
        return 'events';
    }

    /**
     * Register the typical authentication routes for an application.
     *
     * @param  array  $options
     * @return void
     *
     * @throws \RuntimeException
     */

    public static function loadEvents(){
        //Event::loadEvents();
    }

    public function notConnected(){
        return $this->setResponse(new Response((new Errors(
            [Response::getLangValue('NOT_CONNECTED_WITH_TREE')]
        ))->getErrors(), 404));
    }

    public function setAncestors($node_id = false){

        if (!$node_id){
            return $this->notConnected();
        }

        $node = Link::getNode($node_id);

        $this->ancestors['father'] = $this->cycleSearch($node_id, 7);

        if ($node->m_id){
            $this->ancestors['mather'] = $this->cycleSearch($node->m_id, 5);
        }

        // if ($node->m_id){
        //     $this->ancestors['mather'] = $this->cycleSearch($node->m_id, 5);
        // }

        $this->ancestors['family'] = 1;
        $this->ancestors['subscribers'] = 1;
        $this->ancestors['my'] = 1;

        return $this;

    }

    public function isInAncestors($genom){

        $result = false;
        foreach ($this->ancestors as $key=>$value){
            if (is_int($value)) continue;
            if (in_array($value, $genom)){
                $result = $key;
                break;
            }
        }

        return $result;

    }

    private function cycleSearch(int $node_id, int $level){

        $count = 0;
        while ($count < $level){
			$node = link::getNodeFather($node_id);
			if ($node){
				if ($node->f_id){
					$node_id = $node->f_id;
					$count++;
				}else{
					$count = $level;
				}
			}else{
				$count = $level;
			}
		}

        return NUMtoSTRING($node_id);

    }

    public function model(){
        return $this->model;
    }

    public function subs(){
        return $this->subs;
    }

    public function reminder(){
        return $this->reminder;
    }

    public function getAncestors(){
        return $this->ancestors;
    }

}