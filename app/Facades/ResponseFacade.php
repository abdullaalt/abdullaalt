<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

use App\Enums\RusEnums;

class ResponseFacade extends Facade
{

    private $data;
    private $code = 200;
    private $paginator = false;
    //static $lang = RusEnums;

    function __construct($data, $code, $paginator = false){
        $this->data = $data;
        $this->code = $code;
        $this->paginator = $paginator;

        return $this;
    }

    protected static function getFacadeAccessor()
    {
        return 'response';
    }

    public function isFail(){

        if ($this->code >=200 AND $this->code < 300){
            return false;
        }else{
            return true;
        }

    }

    public function isAccept(){
        return !$this->isFail();
    }

    public function replaceData($data){
        $this->data = $data;
        return $this;
    }

    public function getData(){
        return $this->data;
    }

    public function getCode(){
        return $this->code;
    }

    static function getLangValue($key){
        return RusEnums::get($key);
    }

    public function json(){
        
        if ($this->paginator){
            $this->paginator->data = $this->data;
            $this->data = $this->paginator;
        }
        
        return response()->json($this->data, $this->code);
    }
    
}