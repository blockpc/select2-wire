<?php

declare(strict_types=1);

namespace Blockpc\Select2Wire\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

final class Select2DeleteCommand extends Command
{
    protected $signature = 'select2:delete 
                            {name? : A name for component to delete}';

    protected $description = 'Delete a select2 component class';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        if ( ! $name = $this->argument('name') ) {
            $this->error('A name is required!');
            return 1;
        }

        $select_class = Str::studly($name) . 'Select2';
        if ( ! File::exists( app_path("Http/Livewire/Select2/{$select_class}.php") ) ) {
            $this->error("A Component {$select_class} does not exists!");
            return 1;
        }

        unlink(app_path("Http/Livewire/Select2/{$select_class}.php"));

        $this->error("A Component {$select_class} was deleted!");
    }
}