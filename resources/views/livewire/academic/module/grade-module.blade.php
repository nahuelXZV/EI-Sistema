<div>
    <x-shared.container :breadcrumbs="$breadcrumbs">
        <div class="relative overflow-hidden bg-white  dark:bg-gray-800 sm:rounded-lg">
            <div class="flex-row items-center justify-between p-4 space-y-3 sm:flex sm:space-y-0 sm:space-x-4">
                <div>
                    <h5 class="mr-3 text-lg font-bold dark:text-white uppercase">{{ $module->nombre }}</h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Registrar notas</p>
                </div>
                <div class="flex items-center space-x-3">
                    <x-shared.button-header title="Volver" route="program.module" :params="[$module->id]" />
                    <x-shared.button-header title="Guardar" type="button" clickAction="save" />
                </div>
            </div>
        </div>

        <div class="max-w px-4 py-8 mx-auto">
            <section>
                <div class="flex items">
                    <h5 class="text-lg font-bold dark:text-white uppercase">Listado de estudiantes</h5>
                </div>
                <div class="overflow-x-auto p-4  ">
                    <table class="w-full text-sm text-left">
                        <thead class="text-md text-white uppercase bg-fondo dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th scope="col" class="px-4 py-3">Foto</th>
                                <th scope="col" class="px-4 py-3">Nombre</th>
                                <th scope="col" class="px-4 py-3">Observaciones</th>
                                <th scope="col" class="px-4 py-3">Nota</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($arrayStudentsInscription as $student)
                                <tr
                                    class="border-b dark:border-gray-700 @if ($loop->even) bg-gray-100 dark:bg-gray-800 @endif">
                                    <th scope="row"
                                        class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items">
                                            <img class="w-10 h-10" src="{{ asset($student->foto) }}">
                                        </div>
                                    </th>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $student->honorifico . ' ' . $student->nombre . ' ' . $student->apellido }}
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <input type="text" wire:model='observations.{{ $student->id }}'
                                            class="w-full p-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            placeholder="Observaciones">
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <input type="number" min="0" max="100"
                                            wire:model="grades.{{ $student->id }}"
                                            class="w-32 p-2 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            placeholder="0">
                                        @if ($arrayError['hasError'] && $arrayError['idStudent'] == $student->id)
                                            <br>
                                            <x-shared.validate-error :message="$arrayError['message']" />
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </x-shared.container>
</div>
