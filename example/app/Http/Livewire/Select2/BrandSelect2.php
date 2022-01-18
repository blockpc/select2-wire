<?php

declare(strict_types=1);

namespace App\Http\Livewire\Select2;

use Livewire\Component;
use App\Models\Brand;

/**
 * Single Select2 Component with parent model
 *
 * @package Blockpc\Select2Wire
 */
class BrandSelect2 extends Component
{
    public Brand $brand;

    public $search;

    protected $listeners = [
        'set-brand' => 'set_brand',
        'clear'
    ];

    public function mount()
    {
        $this->brand = new Brand;
    }

    public function getOptionsProperty()
    {
        return Brand::where('name', 'LIKE', "%{$this->search}%")->get();
    }

    public function render()
    {
        return view('livewire.select2.brand-select2', [
            'options' => $this->options,
        ]);
    }

    public function save()
    {
        $this->brand = Brand::firstOrCreate(['name' => $this->search]);
        $this->search = "";
        $this->emitTo('vehicles.form-vehicle', 'set-brand', $this->brand->id);
    }

    public function select(Brand $brand)
    {
        $this->brand = $brand;
        $this->emitTo('vehicles.form-vehicle', 'set-brand', $brand->id);
    }

    /** listener */
    public function clear()
    {
        $this->brand = new Brand;
        $this->reset('search');
    }

    /** listener */
    public function set_brand(Brand $brand)
    {
        $this->brand = $brand;
    }
}