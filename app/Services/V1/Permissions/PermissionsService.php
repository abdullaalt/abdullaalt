<?php
namespace App\Services\V1\Permissions;

use Response;
use Errors;

use App\Facades\MainFacade;

class PermissionsService extends MainFacade
{

        private $controller;

        public function __construct($class)
        {
                $this->controller = new $class();
        }

        public function havePermissions($action, $source)
        {
                return $this->controller->havePermissions($action, $source);
        }

        public function fail403()
        {
                $this->setResponse(new Response((new Errors(
                        [Response::getLangValue('HAVE_NOT_PERMISSIONS')]
                ))->getErrors(), 403));

                return $this->response()->json();
        }

}