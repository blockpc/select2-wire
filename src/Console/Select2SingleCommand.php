<?php

declare(strict_types=1);

namespace Blockpc\Select2Wire\Console;

use Blockpc\Select2Wire\Helpers\SingleParser;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

final class Select2SingleCommand extends Command
{
    protected $signature = 'select2:single 
                        {name? : A name for component}
                        {--m|model= : A name for model, If it is not provided, the value of the component name will be used}
                        {--p|parent= : A name for model parent}';

    protected $description = 'Create a new single select2 component class';

    protected $type = 'Select2';

    protected $parse;

    public function __construct()
    {
        parent::__construct();

        $this->parse = new SingleParser;
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Livewire\Select2';
    }

    public function handle()
    {
        if ( ! $this->parse->name = $this->argument('name') ) {
            $this->error('A name is required!');
            return 1;
        }

        if ( $this->option('model') ) {
            $model = Str::ucfirst($this->option('model'));
            if (!File::exists(app_path("Models/{$model}.php"))) {
                if ($this->confirm("Do you wish to create {$model} model? [yes/np]", true)) {
                    $this->call('make:model', [
                        'name' => $model
                    ]);
                }
            }
        }

        if ( $this->option('parent') ) {
            $model = Str::ucfirst($this->option('parent'));
            if (!File::exists(app_path("Models/{$model}.php"))) {
                if ($this->confirm("Do you wish to create {$model} parent model? [yes/np]", true)) {
                    $this->call('make:model', [
                        'name' => $model
                    ]);
                }
            }
        }

        $this->doOtherOperations();
    }

    protected function doOtherOperations()
    {
        try {
            $this->info('Preparing component Select2');
    
            $this->parse->model = $this->option('model') ?? $this->argument('name');
            $this->parse->parent = $this->option('parent') ?? "";
    
            $this->parse->createSelect2();
    
            $select_class = Str::studly($this->parse->name) . 'Select2';
            $this->info("Created a component: {$select_class}");
            
            if ($this->confirm('Do you wish to create the view file (Tailwind CSS)? [yes/np]', true)) {
                $this->parse->createView();
                $this->info("Created a view: resources/views/livewire/select2/{$this->argument('name')}-select2.blade.php");
            }
        } catch (\Throwable $th) {
            $this->error('Error! ' . $th->getMessage());
            return 1;
        }
    }
}