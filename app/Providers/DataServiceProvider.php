<?php
namespace App\Providers;
 
use Illuminate\Support\ServiceProvider;
use App\Services\V1\Data\NodeService;
 
class DataServiceProvider extends ServiceProvider
{
    /** 
* Bootstrap the application services. 
* 
* @return void 
*/
    public function boot()
    {
        // 
    }
 
    /** 
* Register the application services. 
* 
* @return void 
*/
    public function register()
    {
        $this->app->bind('App\Services\V1\Data\NodeService', function ($app) {
            return new NodeService();
          });
    }
}