<div>
    <x-shared.container :breadcrumbs="$breadcrumbs">
        <div class="bg-white dark:bg-gray-800 relative sm:rounded-lg overflow-hidden">
            <div class="relative overflow-hidden bg-white  dark:bg-gray-800 sm:rounded-lg">
                <div class="flex-row items-center justify-between p-4 space-y-3 sm:flex sm:space-y-0 sm:space-x-4">
                    <div>
                        <h5 class="mr-3 text-lg font-bold dark:text-white uppercase">Bitacora</h5>
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
                                placeholder="Search">
                        </div>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto p-4  ">
                <table class="w-full text-sm text-left">
                    <thead class="text-md text-white uppercase bg-fondo dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th scope="col" class="px-4 py-3">Id</th>
                            <th scope="col" class="px-4 py-3">Usuario</th>
                            <th scope="col" class="px-4 py-3">Rol</th>
                            <th scope="col" class="px-4 py-3">Tipo</th>
                            <th scope="col" class="px-4 py-3">Accion</th>
                            <th scope="col" class="px-4 py-3">Fecha y Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activityLogs as $activity)
                            <tr
                                class="border-b dark:border-gray-700 @if ($loop->even) bg-gray-100 dark:bg-gray-800 @endif">
                                <th scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $activity->activity_id }}
                                </th>
                                <th scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $activity->nombre . ' ' . $activity->apellido ?? 'Sin usuario' }}
                                </th>
                                <th scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $activity->nombre_rol ?? 'Sin rol' }}
                                </th>
                                <th scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $activity->description }}
                                </th>
                                <th scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    @php
                                        switch ($activity->event) {
                                            case 'created':
                                                echo 'Creado';
                                                break;
                                            case 'deleted':
                                                echo 'Eliminado';
                                                break;
                                            case 'updated':
                                                echo 'Actualizado';
                                                break;
                                            default:
                                                echo $activity->event;
                                                break;
                                        }
                                    @endphp
                                </th>
                                <th scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $activity->date }}
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav class="px-1 py-3">
                    {{ $activityLogs->links() }}
                </nav>
            </div>
        </div>
    </x-shared.container>
</div>
