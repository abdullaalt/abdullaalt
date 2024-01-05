<?php

        namespace App\Contracts\Events;
        
        interface EventsItemActionContract{
            public function __invoke($event_id);
        } 