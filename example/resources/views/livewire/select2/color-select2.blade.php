<div>
    <div class="my-1 w-64" x-data="{open:false}" x-on:click.away="open=false">
        <button type="button" class="border border-gray-300 p-2 rounded text-black shadow-inner w-full flex justify-between items-center text-sm focus:outline-none" x-on:click="open=!open">
            <span class="float-left">{{__('Select colors')}}</span>
            <svg class="h-4 transform float-right fill-current text-black" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129" :class="{'rotate-180': open}">
                <g>
                    <path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z"/>
                </g>
            </svg>
        </button>
        <div class="absolute z-10 w-64 rounded shadow-md my-2 bg-white" x-show="open" x-cloak>
            <ul class="list-reset p-2 max-h-64 overflow-y-auto text-sm">
                <li>
                    <input wire:model="search" wire:keydown.enter="save" @keydown.enter="open = false; $event.target.blur()" type="text" class="border-2 rounded h-10 w-full p-2">
                </li>
                @forelse ($options as $item)
                <li class="" wire:click="select({{$item->id}})" x-on:click="open=false" id="color-{{$item->id}}">
                    <p class="p-2 w-full text-black hover:bg-gray-300 flex justify-between items-center cursor-pointer @if($colors->contains('id', $item->id)) bg-gray-200 @endif">
                        <span>{{$item->name}}</span>
                        @if ($colors->contains('id', $item->id))
                        <svg class="float-right" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"><path d="M6.61 11.89L3.5 8.78 2.44 9.84 6.61 14l8.95-8.95L14.5 4z"/></svg>
                        @endif
                    </p>
                </li>
                @empty
                <li x-on:click="open=false" id="no-color">
                    <p class="p-2 block text-red-800 hover:bg-red-200 cursor-pointer" value="0">{{__('No colors founds')}}</p>
                </li>
                @endforelse
            </ul>
        </div>
        <div class="py-2 flex items-center space-x-2 flex-wrap">
            @foreach ($colors as $key => $color)
                <div class="inline-flex items-center space-x-2 px-2 py-1 text-sm font-bold leading-none text-green-700 bg-green-300 rounded-full mb-1">
                    <span class="font-semibold">{{$color['name']}}</span>
                    <span wire:click="remove({{$key}})" class="text-red-600 font-bold ml-2 text-base cursor-pointer">x</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
