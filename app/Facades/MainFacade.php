<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use Laravel\Ui\UiServiceProvider;
use RuntimeException;
use Response;
use Errors;

use App\Models\V1\User\User;

class MainFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */

    public int $node_id;
    private object $data;
    public int $user_id;
    private object $response;
    private object $foreight_data;
    private $paginator = false;

    protected static function getFacadeAccessor()
    {
        return 'main';
    }

    /**
     * Register the typical authentication routes for an application.
     *
     * @param  array  $options
     * @return void
     *
     * @throws \RuntimeException
     */

    public function checkCondition($data){

        return true;

    }

    /*
        устанавливаем ответ
        @param object response
        @return this
    */
    public function setResponse($response){
        $this->response = $response;
        return $this;
    }

    /*
        установка данных с которыми работаем
        @param object data
        @return this  
    */
    public function setData($data){
        $this->data = $data;
        return $this;
    }

    /*
        установка параметра объекта по ключу и значению
        @param string key 
        @param string value 
        @return this
    */
    public function setDataId($key, $value){
        $this->{$key} = $value;
        return $this;
    }

    /*
        подгрузка данных для другого объекта
        @param class classname
        @param string|int value
        @return this
    */
    public function loadForeignData($class_name, $value){

        $class = new $class_name;

        if (!$class->checkCondition($value)){ 
            return $this;
        }

        $this->foreight_data = $class->loadDataForForeight($value);

        return $this;

    }

    /*
        получени результата подгрузки
        @return array
    */
    public function getForeightData(){
        return isset($this->foreight_data) ? $this->foreight_data : [];
    }

    public function get($property = false){

        if ($this->response()->isFail()) return null;

        if (!$property)
            return $this->data;
        else{
            return $this->getProperty($property);
        }

    }

    public function array(){
        if (method_exists($this->get(), 'toArray'))
            return $this->get()->toArray();
        else
            return (array)$this->get();
    }

    public function has($property = false){

        if ($this->response()->isFail()) return false;

        return isset($this->data->{$property});

    }

    protected function getProperty($property){

        $property = explode('.', $property);
        if (count($property) == 1){
            return isset($this->data->{$property[0]}) ? $this->data->{$property[0]} : null;
        }

        $value = $this->data;

        foreach ($property as $p){
            if (!$this->has($p)) return null;
            $value = $value->{$p};
        }

        return $value;

    }

    /*
        формирует ответ создавая ресурсы исходя из переданного класса ресурса и указанием является ли коллекцией
        @param class resource_name
        @param bool collection
        @return this
    */
    public function addDataToResponse($resource_name, bool $collection = false){
        
        if (!$this->response()->isFail())
            $this->response = $collection ? 
                                            new Response($resource_name::collection((array)$this->data), 200, $this->paginator) 
                                            : 
                                            new Response(new $resource_name($this->data), 200);

        return $this;

    }

    public function addProperty(string $key, $value){
        $this->data->{$key} = $value;
        return $this;
    }

    public function fillData($data){

        if (!$data){
            return $this;
        }

        foreach ($data as $key => $value) {
            $this->addProperty($key, $value);
        }

        return $this;

    }

    public function response(){
        return $this->response;
    }

    /*
        извлечение пагинации, вызывается только для коллекции
        @return this
    */
    public function extractPaginate(){

        $data = $this->data->toArray();
        unset($data['data']);
        $this->paginator = (object)$data;

        return $this;

    }

    /*
        извлекает данные из объекта пагинации
        @return this
    */
    public function extractData(){

        $data = $this->data;
        
        $this->data = (object)$data->items();

        return $this;

    }

    /*
        устанавливает данные и сразу проверяет существование данных
        в случае ошибки возвращает установленную константу
        @param object data
        @param string const
        @return void
    */
    public function checkDataConditions($data, $const, $code = 404){
        if ($data){
            $this->setData($data);
            $this->setResponse(new Response([], 200));
        }else{
            $this->setResponse(new Response((new Errors(
                [Response::getLangValue($const)]
            ))->getErrors(), $code));
        }
    }

    /*
        сохраняет данные в БД по переданной модели
        если массив array ложно, то забирает текущие данные
        с помощью array можно ограничить список сохраняемых данных
        field и property задает условие для поиска
        @param class model_class
        @param array array
        @param string field
        @param string property
        @return void
    */
    public function save($model_class, $array = false, $field = 'id', $property = 'id'){
        if ($array){
            $data = [];
            foreach ($array as $key => $value) {
                $data[$value] = $this->get($value);
            }

            return $model_class::updateOrCreate([$field => $this->get($property)], $data);
        }else{

            $array = $this->array();

            // foreach ($array as $key => $value) {
            //     $data[$key] = $this->get($value);
            // }
            //dd($array);
            return $model_class::updateOrCreate([$field => $this->get($property)], $array);

        }
    }

}