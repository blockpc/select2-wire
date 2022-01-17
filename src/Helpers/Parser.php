<?php

declare(strict_types=1);

namespace Blockpc\Select2Wire\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

abstract class Parser
{
    protected $name;
    protected $model;
    protected $parent;
    protected $vars;
    protected $class_model;
    protected $select_class;

    protected function setVars($name, $model, $parent) : void
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

    protected function create(string $stub, string $path, string $file) : void
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

    abstract protected function get_type_class() : string;

    abstract protected function get_type_view() : string;
}