<?php
            namespace App\Actions\V1\Testing;

            use App\Contracts\Testing\Test1ActionContract;

            class Test1Action implements Test1ActionContract{
            
                public function __invoke() {

                    $object = new object();

                    return $object
                            ->addDataToResponse(resource::class)
                            ->response()
                            ->json();

                }

            }