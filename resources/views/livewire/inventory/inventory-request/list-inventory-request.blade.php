<div>
    <x-shared.container :breadcrumbs="$breadcrumbs">
        <div class="bg-white dark:bg-gray-800 relative sm:rounded-lg overflow-hidden">
            <div class="relative overflow-hidden bg-white  dark:bg-gray-800 sm:rounded-lg">
                <div class="flex-row items-center justify-between p-4 space-y-3 sm:flex sm:space-y-0 sm:space-x-4">
                    <div>
                        <h5 class="mr-3 text-lg font-bold dark:text-white uppercase">Solicitudes de inventario</h5>
                    </div>
                    <div class="flex items-center space-x-1">
                        <div class="relative">
                            <select wire:model.live="filter" id="filter"
                                class="block w-44 px-4 py-2 pr-8 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option value="" selected>Filtrar por Estado</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state }}">{{ $state }}</option>
                                @endforeach
                            </select>
                            <div
                                class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-700">
                                <x-icons.arrow-down />
                            </div>
                        </div>
                        <a href="{{ route('inventory-request.new') }}"
                            class="w-min flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-fondo hover:bg-primary-900 focus:ring-4 focus:ring-fondo dark:bg-fondo dark:hover:bg-primary-900 focus:outline-none dark:focus:ring-fondo">
                            <x-icons.new />
                            Nuevo
                        </a>
                    </div>
                </div>
            </div>
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                <div class="w-full md:w-1/2">
                    <div class="flex items-center">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <x-icons.search />
                            </div>
                            <input type="text" id="simple-search" wire:model.live="search"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Buscar">
                        </div>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto p-4  ">
                <table class="w-full text-sm text-left">
                    <thead class="text-md text-white uppercase bg-fondo dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th scope="col" class="px-4 py-3">ID</th>
                            <th scope="col" class="px-4 py-3">Usuario</th>
                            <th scope="col" class="px-4 py-3">Fecha y Hora</th>
                            <th scope="col" class="px-4 py-3">Estado</th>
                            <th scope="col" class="px-4 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requests as $request)
                            <tr
                                class="border-b dark:border-gray-700 @if ($loop->even) bg-gray-100 dark:bg-gray-800 @endif">
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $request->id }}
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $request->name_user . ' ' . $request->lastname_user }}
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $request->fecha . ' ' . $request->hora }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    @switch($request->estado)
                                        @case('Aprobado')
                                            <span
                                                class="px-2 py-1 text-xs font-semibold leading-5 text-white bg-green-400 rounded-full dark:bg-green-700 dark:text-green-100">
                                                {{ $request->estado }}
                                            </span>
                                        @break

                                        @case('Rechazado')
                                            <span
                                                class="px-2 py-1 text-xs font-semibold leading-5 text-white bg-red-500 rounded-full dark:bg-red-700 dark:text-red-100">
                                                {{ $request->estado }}
                                            </span>
                                        @break

                                        @case('Pendiente')
                                            <span
                                                class="px-2 py-1 text-xs font-semibold leading-5 text-white bg-blue-400 rounded-full dark:bg-red-700 dark:text-red-100">
                                                {{ $request->estado }}
                                            </span>
                                        @break
                                    @endswitch

                                </td>
                                <td
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white flex items-center justify-end">
                                    <x-shared.button icon="show" route="inventory-request.show" color="green"
                                        type="a" :hover="600" :params="$request->id" tonality="400" />
                                    @if ($request->estado == 'Pendiente' && ($request->user_id == auth()->user()->id || auth()->user()->can('eliminar')))
                                        <x-shared.button icon="delete" color="red" type="button" :params="$request->id"
                                            action="delete" />
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <nav class="px-1 py-3">
                {{ $requests->links() }}
            </nav>
        </div>
        @if ($notificacion)
            <x-shared.notificacion :message="$message" :type="$type" />
            @script
                <script>
                    setTimeout(() => {
                        $wire.dispatch('cleanerNotificacion');
                    }, 3500);
                </script>
            @endscript
        @endif
    </x-shared.container>
</div>
