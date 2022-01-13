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
                        {--m|model= : A name for model, If it is not provided, the value of the component name will be used}';

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

        $this->parse->model = $this->option('model') ?? $this->argument('name');

        $this->doOtherOperations();
    }

    protected function doOtherOperations()
    {
        $this->info('Preparing component Select2');

        $contenido = $this->parse->createSelect2();
        $contenido = $this->parse->copyView();

        $select_class = Str::studly($this->parse->name) . 'Select2';
        $this->info("Created a component: {$select_class}");
    }

    protected function getNameInput()
    {
        return Str::ucfirst(trim($this->argument('name')));
    }
}