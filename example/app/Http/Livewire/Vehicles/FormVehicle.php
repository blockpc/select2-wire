<?php

namespace App\Http\Livewire\Vehicles;

use App\Http\Livewire\Select2\Traits\MultipleTrait;
use App\Http\Livewire\Select2\Traits\SingleTrait;
use App\Models\Vehicle;
use Illuminate\Validation\Rule;
use Livewire\Component;

class FormVehicle extends Component
{
    use SingleTrait, MultipleTrait;

    protected $listeners = [
        'set-vehicle' => 'set_vehicle',
        'close' => 'cancel',
        'new',
    ];

    public Vehicle $vehicle;

    public function mount()
    {
        $this->vehicle = new Vehicle;
    }

    public function render()
    {
        return view('livewire.vehicles.form-vehicle');
    }

    public function save()
    {
        $this->validate();
        $this->vehicle->save();
        if ( count($this->colors) ) {
            $this->vehicle->colors()->sync($this->colors);
        }
        $this->new();
        $this->emit('update-table');
        $this->dispatchBrowserEvent('close-form-vehicle');
    }

    protected function rules()
    {
        $rule_unique = $this->vehicle->exists
            ? Rule::unique('vehicles', 'name')->ignore($this->vehicle)
            : Rule::unique('vehicles', 'name');
        return [
            'vehicle.name' => ['required', 'string', 'max:64', $rule_unique],
            'vehicle.brand_id' => ['required', 'exists:brands,id'],
        ];
    }

    public function new()
    {
        $this->resetErrorBag();
        $this->vehicle = new Vehicle;
        $this->clean_colors();
        $this->emitTo('select2.brand-select2', 'clear');
        $this->emitTo('select2.color-select2', 'clear');
    }

    public function cancel()
    {
        $this->resetErrorBag();
        $this->vehicle = new Vehicle;
        $this->clean_colors();
        $this->emitTo('select2.brand-select2', 'clear');
        $this->emitTo('select2.color-select2', 'clear');
        $this->dispatchBrowserEvent('close-form-vehicle');
    }

    public function set_vehicle(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
        $this->colors = $this->vehicle->colors->map(function ($color) {
            return $color->id;
        })->all();
        $this->emitTo('select2.brand-select2', 'set-brand', $this->vehicle->brand->id);
        $this->emitTo('select2.color-select2', 'set-colors', $this->colors);
    }
}
