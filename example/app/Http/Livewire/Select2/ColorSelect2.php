<?php

declare(strict_types=1);

namespace App\Http\Livewire\Select2;

use Livewire\Component;
use App\Models\Color;

/**
 * Multiple Component Select2
 *
 * @package Blockpc\Select2Wire
 */
class ColorSelect2 extends Component
{
    public $search;
    public $colors;

    protected $listeners = [
        'set-colors' => 'set_colors',
        'clear'
    ];

    public function mount()
    {
        $this->colors = collect([]);
    }

    public function getOptionsProperty()
    {
        return Color::where('name', 'LIKE', "%{$this->search}%")->get();
    }

    public function render()
    {
        return view('livewire.select2.color-select2', [
            'options' => $this->options,
        ]);
    }

    public function save()
    {
        $temporal = $this->parse_search();
        foreach( $temporal as $key => $name ) {
            $color = Color::firstOrCreate(['name' => $name]);
            if ( ! $this->colors->contains('id', $color->id) ) {
                $this->colors->push($color->only(['id', 'name']));
                $this->emitTo('vehicles.form-vehicle', 'set-color', $color->id);
            }
        }
        $this->search = "";
    }

    public function select(Color $color)
    {
        if ( ! $this->colors->contains('id', $color->id) ) {
            $this->colors->push($color->only(['id', 'name']));
            $this->emitTo('vehicles.form-vehicle', 'set-color', $color->id);
        }
    }

    public function remove(int $index)
    {
        $this->colors->forget($index);
        $this->emitTo('vehicles.form-vehicle', 'remove-color', $index);
    }

    /** listener */
    public function clear()
    {
        $this->colors = collect([]);
        $this->search = "";
    }

    /** listener */
    public function set_colors(array $colors)
    {
        // This $colors must be an array with ids of colors
        foreach ( $colors as $id ) {
            $color = Color::find($id);
            $this->colors->push($color->only(['id', 'name']));
        }
    }

    private function parse_search()
    {
        $temporal = [];
        $temporal = explode(",", $this->search);
        $temporal = array_filter($temporal, 'strlen');
        $temporal = array_map('trim', $temporal);
        return $temporal;
    }
}