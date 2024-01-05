<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeActionContract extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature =  'make:class {name : The name of the class to create} {path? : The path to create the class} {params?* : The params to create the class}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new class with specified content at the specified path';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $name = ucfirst($this->argument('name'));
        $params = $this->argument('params');
        $path = ucfirst($this->argument('path') ?? app_path());
        
        $arr = [];
        if (count($params) > 0){
            foreach ($params as $key => $value) {
                $arr[] = '$'.$value;
            }
            $params = $arr;
        }

        $params = implode(',', $params);
        //dd($params);
        $file = "app/Actions/V1/{$path}/{$name}Action.php";
        $content = $this->getActionCode($name, $path, $params);
        if (File::exists($file)) {
            $this->error("Class {$name}Action already exists!");
            return;
        }
        File::ensureDirectoryExists("app/Actions/V1/{$path}");
        File::put($file, $content);

        $file = "app/Contracts/{$path}/{$name}ActionContract.php";
        $content = $this->getContractCode($name, $path, $params);
        if (File::exists($file)) {
            $this->error("Class {$name}ActionContract already exists!");
            return;
        }
        File::ensureDirectoryExists("app/Contracts/{$path}");
        File::put($file, $content);

        $this->info("
                    use App\Contracts\\{$path}\\{$name}ActionContract;
                    use App\Actions\V1\\{$path}\\{$name}Action;

                    {$name}ActionContract::class => {$name}Action::class,
                    ");
    }

    public function make(){

    }

    public function getActionCode($ucfirstname, $ucfirstpath, $params){

        $text = "<?php
            namespace App\Actions\V1\\{$ucfirstpath};

            use App\Contracts\\{$ucfirstpath}\\{$ucfirstname}ActionContract;

            class {$ucfirstname}Action implements {$ucfirstname}ActionContract{
            
                public function __invoke({$params}) {

                    $"."object = new object();

                    return $"."object
                            ->addDataToResponse(resource::class)
                            ->response()
                            ->json();

                }

            }";

        return $text;
    }

    public function getContractCode($ucfirstname, $ucfirstpath, $params){

        $text = "<?php

        namespace App\Contracts\\{$ucfirstpath};
        
        interface {$ucfirstname}ActionContract{
            public function __invoke({$params});
        } ";

        return $text;
    }
}
