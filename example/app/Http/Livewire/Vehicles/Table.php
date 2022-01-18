<?php

namespace App\Http\Livewire\Vehicles;

use App\Models\Vehicle;
use Livewire\Component;

class Table extends Component
{
    protected $listeners = [
        'update-table' => '$refresh',
    ];

    public function getVehiclesProperty()
    {
        return Vehicle::latest()->get();
    }

    public function render()
    {
        return view('livewire.vehicles.table', [
            'vehicles' => $this->vehicles,
        ]);
    }

    public function set_vehicle(int $id)
    {
        $this->emitTo('vehicles.form-vehicle', 'set-vehicle', $id);
    }
}
