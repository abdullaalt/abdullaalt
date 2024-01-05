<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;

use App\Contracts\Events\EventsActionContract;
use App\Contracts\Events\EventsItemActionContract;

use App\Http\Requests\Settings\ProfileRequest;

//use App\Models\instConProf;

class EventsController extends Controller {

    public function events(Request $request, EventsActionContract $EventsActionContract){
        return $EventsActionContract($request);
    }

    public function getEvent(int $event_id, EventsItemActionContract $EventsItemActionContract){
        return $EventsItemActionContract($event_id);
    }

}