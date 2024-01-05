<?php
namespace App\Services\V1\Events;

use Response;
use Errors;

use App\Facades\EventsFacade;
use App\Services\V1\Data\FamilyService;
use App\Services\V1\Data\TeipsService;

class EventsService extends EventsFacade
{

        public function getEvents($request, int $node_id)
        {

                if (! $node_id) {
                        return $this->notConnected();
                }

                $this->model()->isApproved(1);

                if ($request->has('type')) {
                        $this->model()->setType($request->type);
                }

                $family = new FamilyService();
                $family->buildFamily($node_id);

                $this->model()->setAncestors($this->getAncestors(),
                        $request,
                        auth()->user(),
                        $family->executeFamilyIds(),
                        $this->subs()->getUserSubs(auth()->id())
                );

                $this->model()->setOrder('events.id', 'desc');

                $items = $this->model()->getData();

                $this->checkDataConditions($items, 'EVENTS_NOT_FOUND');

                return $this;

        }

        public function preparingResult()
        {

                $events = $this->get();
                $result = [];

                foreach ($events as $key => $event) {
                        $result[] = $this->preparingEvent($event);
                }

                $this->setData((object) $result);

                return $this;

        }

        public function preparingSingleResult(){
                $this->setData((object) $this->preparingEvent($this->get()));
                return $this;
        }

        public function preparingEvent($event)
        {dd($event);
                $event->can_see_comments = false;
                $event->teip = null;
                $event->is_remind = $this->reminder()->isRemind($event->id, auth()->id());
                if ($event->person_teip) {
                        $event->teip = $this->loadForeignData(
                                TeipsService::class,
                                $event->person_teip
                        )
                                ->getForeightData();

                        if ($event->teip) {
                                $event->can_see_comments = $event->teip->id == auth()->user()->teip;
                        } else {
                                $event->teip = null;
                        }
                }
                return $this->fillEventsFields($event);
        }

        public function fillEventsFields($event)
        {

                $event->person = null;
                $event->target = null;
                $event->key1 = 'empty';
                $event->key2 = 'empty';

                if ($event->person_id) {
                        $event->person = [
                                'id' => $event->person_id,
                                'fio' => $event->person_fio,
                                'pol' => $event->person_pol,
                                'teip' => $event->person_teip,
                                'user_id' => $event->person_user_id,
                        ];
                }

                if ($event->target_id) {
                        $event->target = [
                                'id' => $event->target_id,
                                'fio' => $event->target_fio,
                                'pol' => $event->target_pol,
                                'teip' => $event->target_teip,
                                'user_id' => $event->targetuser_id,
                        ];
                }

                if ($event->type == 'wedding') {
                        $event->key1 = 'groom';
                        $event->key2 = 'wife';
                } else if ($event->type == 'funeral') {
                        $event->key1 = 'dead';
                } else if ($event->type == 'birth') {
                        $event->key1 = 'father';
                        $event->key2 = 'mather';
                } else if ($event->type == 'fundraising') {
                        $event->key1 = 'organizer';
                } else if ($event->type == 'other') {
                        $event->key1 = 'organizer';
                }

                return $event;

        }

        public function isAccessToEvent(){

                $access = true; 
                $node_id = auth()->user()->tree_number;
                $this->setAncestors($node_id);
                if ($this->get('permission') == 'teip'){

                        if ($this->get('genom')){

                                if ($node_id < 1){
                                    $access = false;    
                                }

                                $genoms = explode(' ', $this->get('genom'));
                                
                                if (!$this->isInAncestors($genoms)){
                                        $access = false;
                                }

                        }else{
                                if ($this->get('teip') != auth()->user()->teip){
                                        $access = false;
                                }
                        }
                       
                }

                $family = new FamilyService();

                if ($this->get('permission') == 'family' && !$family->isInFamily($node_id, $this->get('person_id'))){
                        $access = false;    
                }

                if ($this->get('permission') == 'subscribers' && !$this->subs()->isSubscribers(auth()->id(), $this->get('user_id'))){
                        $access = false;    
                }

                if (!$access){
                        return $this->setResponse(new Response((new Errors(
                                [Response::getLangValue('HAVE_NOT_PERMISSIONS')]
                            ))->getErrors(), 403));
                }

                return true;
        }

}