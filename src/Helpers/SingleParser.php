<?php

declare(strict_types=1);

namespace Blockpc\Select2Wire\Helpers;

final class SingleParser extends Parser
{
    public function sets($name, $model, $parent) : void
    {
        $this->setVars($name, $model, $parent);
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
        $file = "{$path}/Single{$this->class_model}Trait.php";
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
}