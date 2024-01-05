<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature =  'make:service {name : The name of the class to create} {path? : The path to create the class} {params?* : The params to create the class}';

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
//dd($params);
        $extend = $params[0]; //родитель
        $extend_path = $params[1]; //путь до родителя

        //dd($params);
        $file = "app/Services/{$params[2]}/{$path}/{$name}Service.php";
        $content = $this->getServiceCode($name, $path, $extend, $extend_path);
        if (File::exists($file)) {
            $this->error("Class {$name}Action already exists!");
            return;
        }
        File::ensureDirectoryExists("app/Services/{$params[2]}/{$path}");
        File::put($file, $content);

        $this->info("
            app/Services/{$params[2]}/{$path}/{$name}Service.php
        ");
    }

    public function make(){

    }

    public function getServiceCode($ucfirstname, $ucfirstpath, $extend, $extend_path){

        $text = "<?php
        namespace App\Services\V1\\{$ucfirstpath};
        
        use Response;
        use Errors;
        
        use {$extend_path}{$extend};
        
        class {$ucfirstname}Service extends {$extend}{
            
        }";

        return $text;
    }
}
