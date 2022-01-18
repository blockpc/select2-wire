@extends('layouts.backend')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Vehicles') }}
</h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" x-data="{open: 'table'}" @close-form-vehicle.window="open = 'table'">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                            <path d="m20.772 10.156-1.368-4.105A2.995 2.995 0 0 0 16.559 4H7.441a2.995 2.995 0 0 0-2.845 2.051l-1.368 4.105A2.003 2.003 0 0 0 2 12v5c0 .753.423 1.402 1.039 1.743-.013.066-.039.126-.039.195V21a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-2h12v2a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-2.062c0-.069-.026-.13-.039-.195A1.993 1.993 0 0 0 22 17v-5c0-.829-.508-1.541-1.228-1.844zM4 17v-5h16l.002 5H4zM7.441 6h9.117c.431 0 .813.274.949.684L18.613 10H5.387l1.105-3.316A1 1 0 0 1 7.441 6z"></path> <circle cx="6.5" cy="14.5" r="1.5"></circle><circle cx="17.5" cy="14.5" r="1.5"></circle>
                        </svg>
                        <span class="text-lg font-semibold" x-show="open == 'table'">Vehicles List</span>
                        <span class="text-lg font-semibold" x-show="open == 'new'">New Vehicle</span>
                        <span class="text-lg font-semibold" x-show="open == 'edit'">Edit Vehicle</span>
                    </div>
                    <div class="" x-show="open == 'table'">
                        <button type="button" class="p-2 text-white rounded-md bg-blue-800 hover:bg-blue-700 focus:border-blue-900 focus:ring ring-blue-300"
                            x-on:click="open='new', Livewire.emitTo('vehicles.form-vehicle', 'new')">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-5 h-5"
                                    viewBox="0 0 24 24">
                                    <path d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"></path>
                                </svg>
                            </div>
                        </button>
                    </div>
                    <div class="" x-show="open != 'table'" x-cloak>
                        <button type="button" class="p-2 text-white rounded-md bg-yellow-800 hover:bg-yellow-700 focus:border-yellow-900 focus:ring ring-yellow-300"
                            x-on:click="open='table', Livewire.emitTo('vehicles.form-vehicle', 'close')">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-5 h-5"
                                    viewBox="0 0 24 24">
                                    <path d="M5 11h14v2H5z"></path>
                                </svg>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
            <div class="p-6 bg-white border-gray-200">
                <div x-show="open == 'table'" id="vehicles-table-{{auth()->user()->id}}">
                    @livewire('vehicles.table', [], key('vehicles-table-'.auth()->user()->id))
                </div>
                <div x-show="open != 'table'" id="vehicles-form-vehicle-{{auth()->user()->id}}">
                    @livewire('vehicles.form-vehicle', [], key('vehicles-form-vehicle-'.auth()->user()->id))
                </div>
            </div>
        </div>
    </div>
</div>
@endsection