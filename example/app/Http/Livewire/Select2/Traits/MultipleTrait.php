<?php

namespace App\Http\Livewire\Select2\Traits;

/**
 * Trait for Multiple / Parent Component Select2
 *
 * @package Blockpc\Select2Wire
 */
trait MultipleTrait
{
    public $colors = [];

    public function initializeMultipleTrait()
    {
        $this->listeners = array_merge($this->listeners, [
            'set-color' => 'set_color',
            'remove-color' => 'remove_color'
        ]);
    }

    public function set_color(int $id)
    {
        $this->colors[] = $id;
    }

    public function remove_color(int $id)
    {
        $this->colors = array_diff($this->colors, [$id]);
    }

    public function clean_colors()
    {
        $this->colors = [];
    }
}