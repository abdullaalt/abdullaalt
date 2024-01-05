<?php
            namespace App\Actions\V1\Permissions;

            use App\Contracts\Permissions\PermissionsActionContract;

            class PermissionsAction implements PermissionsActionContract{
            
                public function __invoke($MainFacade,$App\Facades\) {

                    $object = new object();

                    return $object
                            ->addDataToResponse(resource::class)
                            ->response()
                            ->json();

                }

            }