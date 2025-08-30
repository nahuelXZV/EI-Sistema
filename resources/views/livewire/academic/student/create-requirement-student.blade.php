<div>
    <x-shared.container :breadcrumbs="$breadcrumbs">
        <div class="bg-white dark:bg-gray-800 relative sm:rounded-lg overflow-hidden">
            <div class="relative overflow-hidden bg-white  dark:bg-gray-800 sm:rounded-lg">
                <div class="flex-row items-center justify-between p-4 space-y-3 sm:flex sm:space-y-0 sm:space-x-4">
                    <div>
                        <h5 class="mr-3 text-lg font-bold dark:text-white uppercase">Requisitos</h5>
                    </div>
                    <button wire:click="save" type="button"
                        class="w-min flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-fondo hover:bg-primary-900 focus:ring-4 focus:ring-fondo dark:bg-fondo dark:hover:bg-primary-900 focus:outline-none dark:focus:ring-primary-800">
                        Guardar
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto p-4  ">
                <table class="w-full text-sm text-left">
                    <thead class="text-md text-white uppercase bg-fondo dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th scope="col" class="px-4 py-3">Nombre</th>
                            <th scope="col" class="px-4 py-3">Requerido</th>
                            <th scope="col" class="px-4 py-3">Documento</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requirements as $requirement)
                            <tr
                                class="border-b dark:border-gray-700 @if ($loop->even) bg-gray-100 dark:bg-gray-800 @endif">
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $requirement->nombre }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $requirement->requerido ? 'Sí' : 'No' }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <input type="file" name="documents"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        wire:model.defer='documents.{{ $requirement->id }}'>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-shared.container>
</div>
