<div>
    <div class="block w-full overflow-x-auto">
        <table class="items-center bg-transparent w-full border-collapse">
            <thead>
                <tr>
                    <th
                        class="px-6 bg-blueGray-50 text-blueGray-500 border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                        Nombre</th>
                    <th
                        class="px-6 bg-blueGray-50 text-blueGray-500 border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                        Marca</th>
                    <th
                        class="px-6 bg-blueGray-50 text-blueGray-500 border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                        Colores</th>
                    <th
                        class="px-6 bg-blueGray-50 text-blueGray-500 border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-right">
                        Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($vehicles as $vehicle)
                <tr>
                    <td class="border-t-0 border-l-0 border-r-0 text-sm whitespace-nowrap p-4">{{$vehicle->name}}
                    </td>
                    <td class="border-t-0 border-l-0 border-r-0 text-sm whitespace-nowrap p-4">
                        {{$vehicle->brand->name}}</td>
                    <td class="border-t-0 border-l-0 border-r-0 text-sm whitespace-nowrap p-4">
                        {{$vehicle->colors->pluck('name')->implode(', ')}}</td>
                    <td class="border-t-0 border-l-0 border-r-0 text-sm whitespace-nowrap p-4 float-right">
                        <div class="flex items-center space-x-2">
                            <button type="button" wire:click="set_vehicle({{$vehicle->id}})"
                                class="border border-green-600 text-green-800 hover:bg-green-600 hover:text-white py-1 px-2 mb-2 rounded-md text-sm font-semibold"
                                x-on:click="open='edit'">Edit</button>
                            <button type="button"
                                class="border border-red-600 text-red-800 hover:bg-red-600 hover:text-white py-1 px-2 mb-2 rounded-md text-sm font-semibold">Delete</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="border-t-0 border-l-0 border-r-0 text-sm whitespace-nowrap p-4 text-center"
                        colspan="4">Sin vehículos encontrados</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>