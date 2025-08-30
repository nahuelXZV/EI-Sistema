<div>
    <x-shared.container :breadcrumbs="$breadcrumbs">
        <div class="relative overflow-hidden bg-white  dark:bg-gray-800 sm:rounded-lg">
            <div class="flex-row items-center justify-between p-4 space-y-3 sm:flex sm:space-y-0 sm:space-x-4">
                <div>
                    <h5 class="mr-3 text-lg font-bold dark:text-white uppercase">{{ $program->nombre }}</h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Inscribir estudiantes</p>
                </div>
                <div class="flex items-center space-x-3">
                    <x-shared.button-header title="Volver" route="program.show" :params="[$program->id]" />
                    <x-shared.button-header title="Guardar" type="button" clickAction="save" confirmMessage="true" />
                </div>
            </div>
        </div>

        <div class="max-w px-4 py-8 mx-auto">
            <section>
                <div class="flex items">
                    <h5 class="text-lg font-bold dark:text-white uppercase">Listado de estudiantes</h5>
                </div>
                <div
                    class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
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
                                <th scope="col" class="px-4 py-3">Foto</th>
                                <th scope="col" class="px-4 py-3">Nombre</th>
                                <th scope="col" class="px-4 py-3">Cedula</th>
                                <th scope="col" class="px-4 py-3">Correo</th>
                                <th scope="col" class="px-4 py-3">Descuento</th>
                                <th scope="col" class="px-4 py-3">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
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
                                        {{ $student->cedula . ' ' . $student->expedicion }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $student->correo }}
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <select
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            wire:model="studentDiscounts.{{ $student->id }}"
                                            @if (!empty($studentDiscounts[$student->id]) || in_array($student->id, $listStudent)) disabled @endif>
                                            <option value="">Seleccionar descuento</option>
                                            @foreach ($discountArray as $discount)
                                                <option value="{{ $discount->id }}">{{ $discount->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td
                                        class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white flex items-center justify-center">
                                        <input type="checkbox" value="{{ $student->id }}" @checked(in_array($student->id, $listStudent))
                                            id="student-{{ $student->id }}" wire:click="add({{ $student->id }})"
                                            class="w-6 h-6 text-blue-600 bg-gray-300 border-gray-500 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <nav class="px-1 py-3">
                    {{ $students->links() }}
                </nav>
            </section>
        </div>
    </x-shared.container>
</div>
