<?php
namespace App\Actions\V1\Testing;

use App\Contracts\Testing\Test2ActionContract;

class Test2Action implements Test2ActionContract
{

    public function __invoke($test1, $test2, $test3)
    {

        $object = new object();

        return $object
            ->addDataToResponse(resource::class)
            ->response()
            ->json();

    }

}