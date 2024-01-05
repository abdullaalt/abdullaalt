<?php
namespace App\Actions\V1\Events;

use App\Contracts\Events\EventsActionContract;

use App\Services\V1\Events\EventsService;

use App\Http\Resources\V1\Events\EventResource;

class EventsAction implements EventsActionContract
{

    public function __invoke($request)
    {

        $events = new EventsService();

        if (auth()->user()->tree_number < 1){
            return $events->notConnected();
        }

        
        $events->init(auth()->user()->tree_number)
                ->getEvents($request, auth()->user()->tree_number);

        if ($events->response()->isFail()){
            return $events->response()->json();
        }

        $events->extractPaginate()
                ->extractData();
        $events->preparingResult();

        return $events
            ->addDataToResponse(EventResource::class, true)
            ->response()
            ->json();

    }

}