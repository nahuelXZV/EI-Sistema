<div>
    <x-shared.container :breadcrumbs="$breadcrumbs">
        <div class="bg-white dark:bg-gray-800 relative sm:rounded-lg overflow-hidden">
            <div class="relative overflow-hidden bg-white  dark:bg-gray-800 sm:rounded-lg">
                <div class="flex-row items-center justify-between p-4 space-y-3 sm:flex sm:space-y-0 sm:space-x-4">
                    <div>
                        <h5 class="mr-3 text-lg font-bold dark:text-white uppercase">Directivos</h5>
                    </div>
                    <a href="{{ route('leader.new') }}"
                        class="w-min flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-fondo hover:bg-primary-900 focus:ring-4 focus:ring-fondo dark:bg-fondo dark:hover:bg-primary-900 focus:outline-none dark:focus:ring-fondo">
                        <x-icons.new />
                        Nuevo
                    </a>
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
                            <th scope="col" class="px-4 py-3">Nombre</th>
                            <th scope="col" class="px-4 py-3">Cargo</th>
                            <th scope="col" class="px-4 py-3">Activo</th>
                            <th scope="col" class="px-4 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leaders as $leader)
                            <tr wire:key="{{ $leader->id }}"
                                class="border-b dark:border-gray-700 @if ($loop->even) bg-gray-100 dark:bg-gray-800 @endif">
                                <th scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $leader->honorifico . ' ' . $leader->nombre . ' ' . $leader->apellido }}
                                </th>
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $leader->cargo }} <br>
                                    <span class="text-xs font-normal text-gray-500 dark:text-gray-400">
                                        {{ $leader->institucion }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    @if ($leader->activo)
                                        <span
                                            class="px-2 py-1 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                            Activo
                                        </span>
                                    @else
                                        <span
                                            class="px-2 py-1 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                            Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white flex items-center justify-end">
                                    <x-shared.button icon="edit" route="leader.edit" color="blue" type="a"
                                        :params="$leader->id" />
                                    @can('eliminar')
                                        <x-shared.button icon="delete" color="red" type="button" :params="$leader->id"
                                            action="delete" />
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <nav class="px-1 py-3">
                {{ $leaders->links() }}
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
