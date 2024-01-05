<?php
namespace App\Actions\V1\Events;

use App\Contracts\Events\EventsItemActionContract;

use App\Services\V1\Events\EventsItemService;

use App\Http\Resources\V1\Events\EventResource;

class EventsItemAction implements EventsItemActionContract
{

    public function __invoke($event_id)
    {

        $event = new EventsItemService();
        
        $event->init(auth()->user()->tree_number)
                ->getEvent($event_id);

        if ($event->response()->isFail()){
            return $event->response()->json();
        }

        $event->isAccessToEvent();

        if (!$event->response()->isFail()){
            return $event->response()->json();
        }
        
        $event->preparingSingleResult();

        return $event
            ->addDataToResponse(EventResource::class)
            ->response()
            ->json();
    }

}