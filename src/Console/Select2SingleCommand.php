<?php

declare(strict_types=1);

namespace Blockpc\Select2Wire\Console;

use Blockpc\Select2Wire\Helpers\SingleParser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

final class Select2SingleCommand extends Command
{
    protected $signature = 'select2:single 
                        {name? : A name for component}
                        {--m|model= : A name for model, If it is not provided, the name of component will be used}
                        {--p|parent= : A name for model parent}';

    protected $description = 'Create a new single select2 component class';

    protected $type = 'Select2';

    protected $parse;

    public function __construct()
    {
        parent::__construct();

        $this->parse = new SingleParser;
    }

    public function handle()
    {
        if ( ! $this->parse->name = $this->argument('name') ) {
            $this->error('A name is required!');
            return 1;
        }

        $select_class = Str::studly($this->parse->name) . 'Select2';
        if ( File::exists( app_path("Http/Livewire/Select2/{$select_class}.php") ) ) {
            $this->error("A Component {$select_class} exists!");
            return 1;
        }

        if ( $this->option('model') ) {
            $model = Str::ucfirst($this->option('model'));
            if ( ! File::exists(app_path("Models/{$model}.php")) ) {
                if ($this->confirm("Do you wish to create {$model} model?") ) {
                    $this->call('make:model', [
                        'name' => $model
                    ]);
                }
            }
        }

        if ( $this->option('parent') ) {
            $model = Str::ucfirst($this->option('parent'));
            if ( ! File::exists(app_path("Models/{$model}.php")) ) {
                if ($this->confirm("Do you wish to create {$model} parent model?") ) {
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
            $this->info('Preparing single component Select2');

            $this->parse->setVars(
                $this->argument('name'),
                $this->option('model'),
                $this->option('parent')
            );
            
            $this->parse->createSelect2();
            $this->info("Created a component: {$this->parse->select_class}");
            
            if ( $this->confirm('Do you wish to create the view file (Tailwind CSS)?', true) ) {
                $this->parse->createView();
                $this->info("Created a view: resources/views/livewire/select2/{$this->parse->name}-select2.blade.php");
            }

            if ( $this->option('parent') ) {
                if ( $this->confirm('Do you wish to create a trait for parent model?', true) ) {
                    $this->parse->createTrait();
                    $this->info("Created a trait: App/Http/Livewire/Select2/Traits/SingleTrait.php");
                }
            }
        } catch (\Throwable $th) {
            $this->error('Error! ' . $th->getMessage());
            return 1;
        }
    }
}