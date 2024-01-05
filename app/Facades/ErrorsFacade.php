<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use Laravel\Ui\UiServiceProvider;
use RuntimeException;
use Response;

use App\Models\V1\User\User;

class ErrorsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */

    private array $errors = [];

    function __construct($error = false){
        if ($error){
            $this->errors[] = $error;
        }

        //return $this;
    }

    public function add($error = false){
        if ($error){
            $this->errors[] = $error;
        }
        return $this;
    }

    public function get(){
        return ['errors'=>$this->errors];
    }

    public function getErrors(){
        return $this->get();
    }

    protected static function getFacadeAccessor()
    {
        return 'errors';
    }

    /**
     * Register the typical authentication routes for an application.
     *
     * @param  array  $options
     * @return void
     *
     * @throws \RuntimeException
     */

    
    
}