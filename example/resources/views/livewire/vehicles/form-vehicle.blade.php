<div>
    <form wire:submit.prevent="save" class="w-full">
        <div class="grid grid-cols-3 gap-4">
            {{-- Name --}}
            <div class="col-span-3 md:col-span-1">
                <label for="name" class="w-full">{{__('Name')}}</label>
                <div class="flex flex-col w-full">
                    <input wire:model="vehicle.name" type="text"
                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2 sm:text-sm border-gray-300 rounded-md"
                        placeholder="{{__('Name')}}">
                </div>
            </div>

            {{-- Brand --}}
            <div class="col-span-3 md:col-span-1">
                <label for="name" class="w-full">{{__('Brand')}}</label>
                <div class="flex flex-col w-full" id="select2-brand-select2">
                    @livewire('select2.brand-select2', [], key('select2-brand-select2-'.auth()->user()->id))
                </div>
            </div>

            {{-- Color --}}
            <div class="col-span-3 md:col-span-1">
                <label for="name" class="w-full">{{__('Color')}}</label>
                <div class="flex flex-col w-full" id="select2-color-select2">
                    @livewire('select2.color-select2', [], key('select2-color-select2-'.auth()->user()->id))
                </div>
            </div>
        </div>
        <div class="flex flex-col md:flex-row md:justify-between items-center mt-2">
            <div class="flex flex-col space-y-1" id="errors">
                @error('vehicle.name')
                <span class="text-red-500 font-semibold text-sm">{{ $message }}</span>
                @enderror
                @error('vehicle.brand_id')
                <span class="text-red-500 font-semibold text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex items-center space-x-2" id="btns">
                <button
                    class="px-3 py-2 rounded-md bg-blue-800 hover:bg-blue-700 active:bg-blue-900 focus:border-blue-900 focus:ring ring-blue-300 text-white">{{__('Save')}}</button>
                <button type="button"
                    class="px-3 py-2 rounded-md bg-yellow-800 hover:bg-yellow-700 active:bg-yellow-900 focus:border-yellow-900 focus:ring ring-yellow-300 text-white"
                    wire:click="cancel">{{__('Cancel')}}</button>
            </div>
        </div>
    </form>
</div>