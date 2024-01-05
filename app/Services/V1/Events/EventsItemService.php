<?php
namespace App\Services\V1\Events;

use Response;
use Errors;

use App\Services\V1\Events\EventsService;
use App\Services\V1\Data\FamilyService;

use App\Models\V1\Events\TreeSubscription;

class EventsItemService extends EventsService
{
        public function getEvent($event_id){

                $this->init();

                $event = $this->model()
                                ->getEvent($event_id);
                
                $this->checkDataConditions($event, 'EVENT_NOT_FOUND');
                
                return $this;

        }
}