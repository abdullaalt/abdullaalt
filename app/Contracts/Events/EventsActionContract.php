<?php

        namespace App\Contracts\Events;
        
        interface EventsActionContract{
            public function __invoke($request);
        } 