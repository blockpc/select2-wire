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
    public $multiple;
    public $vars;
	
	public function createSelect2() : void
    {
        $class_model = Str::ucfirst($this->model);
        $select_class = Str::studly($this->name) . 'Select2';
        $this->vars = [
            'CLASS_MODEL' => $class_model,
            'SELECT_CLASS' => $select_class,
            'MODEL' => $this->model,
            'VIEW_NAME' => $this->name,
            'CLASS_PARENT' => Str::ucfirst($this->parent ?: 'parent'),
            'PARENT' => $this->parent ?: 'parent',
            'MODEL_PLURAL' => Str::plural($this->model),
        ];
        $directory = $this->get_type_class();
        $content = file_get_contents($directory);
        foreach($this->vars as $clave => $valor) {
            $pos = strpos($content, '[' . strtoupper($clave) . ']');
            if ( $pos !== FALSE ) {
                $content = str_replace('[' . strtoupper($clave) . ']', $valor, $content);
            }
        }
        $path = app_path("Http/Livewire/Select2");
        if ( !File::exists($path) ) {
            File::ensureDirectoryExists($path, 0777, true, true);
        }
        $file = "{$path}/{$select_class}.php";
        file_put_contents($file, $content);
    }

    public function createView() : void
    {
        $view = $this->get_type_view();
        $content = file_get_contents($view);
        foreach($this->vars as $clave => $valor) {
            $pos = strpos($content, '[' . strtoupper($clave) . ']');
            if ( $pos !== FALSE ) {
                $content = str_replace('[' . strtoupper($clave) . ']', $valor, $content);
            }
        }
        $path = resource_path("views/livewire/select2");
        if ( !File::exists($path) ) {
            File::ensureDirectoryExists($path, 0777, true, true);
        }
        $file = "{$path}/{$this->name}-select2.blade.php";
        file_put_contents($file, $content);
    }

    protected function get_type_class() : string
    {
        if ( $this->multiple ) {
            return $this->multiple 
                ? __DIR__ . '/../../stubs/classes/multiple-parent.stub'
                : __DIR__ . '/../../stubs/classes/multiple.stub';
        } else {
            return $this->parent 
                ? __DIR__ . '/../../stubs/classes/single-parent.stub' 
                : __DIR__ . '/../../stubs/classes/single.php.stub';
        }
    }

    protected function get_type_view() : string
    {
        if ( $this->multiple ) {
            return $this->multiple 
                ? __DIR__ . '/../../stubs/views/tailwind/multiple-parent.stub'
                : __DIR__ . '/../../stubs/views/tailwind/multiple.stub';
        } else {
            return __DIR__ . '/../../stubs/views/tailwind/single.stub';
        }
    }
}