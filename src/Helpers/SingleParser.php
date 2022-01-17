<?php

declare(strict_types=1);

namespace Blockpc\Select2Wire\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

final class SingleParser extends Parser
{
    public $name;
    public $model;
    public $parent;
    public $vars;
    public $class_model;
    public $select_class;

    public function setVars($name, $model, $parent) : void
    {
        $this->name = $name;
        $this->model = $model ?? $name;
        $this->parent = $parent;
        $this->class_model = Str::ucfirst($this->model);
        $this->select_class = Str::studly($this->name) . 'Select2';
        $this->vars = [
            'CLASS_MODEL' => $this->class_model,
            'SELECT_CLASS' => $this->select_class,
            'MODEL' => $this->model,
            'VIEW_NAME' => $this->name,
            'CLASS_PARENT' => Str::ucfirst($this->parent ?: 'parent'),
            'PARENT' => $this->parent ?: 'parent',
            'MODEL_PLURAL' => Str::plural($this->model),
        ];
    }
	
	public function createSelect2() : void
    {
        $stub = $this->get_type_class();
        $path = app_path("Http/Livewire/Select2");
        $file = "{$path}/{$this->select_class}.php";
        $this->create($stub, $path, $file);
    }

    public function createView() : void
    {
        $stub = $this->get_type_view();
        $path = resource_path("views/livewire/select2");
        $file = "{$path}/{$this->name}-select2.blade.php";
        $this->create($stub, $path, $file);
    }

    public function createTrait() : void
    {
        $stub = __DIR__ . '/../../stubs/traits/single-trait.php.stub';
        $path = app_path("Http/Livewire/Select2/Traits");
        $file = "{$path}/SingleTrait.php";
        $this->create($stub, $path, $file);
    }

    protected function get_type_class() : string
    {
        return $this->parent 
            ? __DIR__ . '/../../stubs/classes/single-parent.php.stub' 
            : __DIR__ . '/../../stubs/classes/single.php.stub';
    }

    protected function get_type_view() : string
    {
        return __DIR__ . '/../../stubs/views/tailwind/single.stub';
    }

    private function create(string $stub, string $path, string $file) : void
    {
        $content = file_get_contents($stub);
        foreach($this->vars as $clave => $valor) {
            $pos = strpos($content, '[' . strtoupper($clave) . ']');
            if ( $pos !== FALSE ) {
                $content = str_replace('[' . strtoupper($clave) . ']', $valor, $content);
            }
        }
        if ( !File::exists($path) ) {
            File::ensureDirectoryExists($path, 0777, true, true);
        }
        file_put_contents($file, $content);
    }
}