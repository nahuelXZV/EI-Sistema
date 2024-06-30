<div>
    <x-shared.container :breadcrumbs="$breadcrumbs">
        <div class="relative overflow-hidden bg-white  dark:bg-gray-800 sm:rounded-lg">
            <div class="flex-row items-center justify-between p-4 space-y-3 sm:flex sm:space-y-0 sm:space-x-4">
                <div>
                    <h5 class="mr-3 text-lg font-bold dark:text-white uppercase">
                        {{ $teacher->honorifico . ' ' . $teacher->nombre . ' ' . $teacher->apellido }}</h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Datos del docente</p>
                </div>
                <div class="flex items-center space-x-3">
                    <x-shared.button-header title="Volver" route="teacher.list" :params="[$teacher->id]" />
                    <x-shared.button-header title="Editar" route="teacher.edit" :params="[$teacher->id]" />
                    @if ($teacher->cv)
                        <x-shared.button-header title="Descargar cv" :route="$teacher->cv" type='download' />
                    @endif
                </div>
            </div>
        </div>

        <div class="max-w px-4 py-8 mx-auto">
            <section>
                <div class="grid gap-4 mb-4 sm:grid-cols-3 sm:gap-6 sm:mb-5">
                    <div class="col-span-3 sm:col-span-1">
                        <div class="flex items center justify-center">
                            <img class="w-40 h-auto rounded-sm"
                                src="{{ $teacher->foto ? asset($teacher->foto) : asset('img/user.png') }}"
                                alt="{{ $teacher->nombre }}">
                            <br>
                        </div>
                        <div class="flex items center justify-center mt-3">
                            <input type="checkbox" wire:click="changeFactura" @checked($teacher->factura)
                                class="form-checkbox h-5 w-5 text-blue-600">
                            <label for="factura" class="ml-2 text-gray-700 dark:text-gray-300">
                                Factura
                            </label>
                        </div>
                        <div class="flex items center justify-center">
                            <x-shared.span :text="'Tickeado si el docente factura'" />
                        </div>
                    </div>
                    <div class="grid gap-4 mb-4 col-span-3 sm:col-span-2 sm:gap-6 sm:mb-5">
                        <x-shared.input-readonly title="Nombre" col='3' :value="$teacher->honorifico . ' ' . $teacher->nombre . ' ' . $teacher->apellido" />

                        <x-shared.input-readonly title="Cedula" col='3' :value="$teacher->cedula . ' - ' . $teacher->expedicion" />
                        @if ($career)
                            <x-shared.input-readonly title="Carrera" col='3' :value="$career->nombre" />
                        @endif
                        @if ($teacher->telefono)
                            <x-shared.input-readonly title="Telefono" col='3' :value="$teacher->telefono" />
                        @endif
                        @if ($teacher->correo)
                            <x-shared.input-readonly title="Correo" col='3' :value="$teacher->correo" />
                        @endif
                    </div>

                </div>
                {{-- areas --}}
                <section>
                    <div class="flex items-center justify-between mt-5">
                        <h5 class="text-lg font-bold dark:text-white uppercase">Areas de profesion</h5>
                        <x-shared.button-header title="Nuevo" route="teacher.area" :params="[$teacher->id]" />
                    </div>
                    <div class="overflow-x-auto p-4  ">
                        <table class="w-full text-sm text-left">
                            <thead class="text-md text-white uppercase bg-fondo dark:bg-gray-700 dark:text-gray-300">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Nombre</th>
                                    <th scope="col" class="px-4 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($areas as $area)
                                    <tr
                                        class="border-b dark:border-gray-700 @if ($loop->even) bg-gray-100 dark:bg-gray-800 @endif">
                                        <th scope="row"
                                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $area->area }}
                                        </th>
                                        </td>
                                        <td class="flex items-center justify-end">
                                            @can('eliminar')
                                                <x-shared.button icon="delete" color="red" type="button"
                                                    :params="$area->id" />
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>


                {{-- contratos --}}
                <section class="mt-5">
                    <div class="flex items">
                        <h5 class="text-lg font-bold dark:text-white uppercase">Contratos</h5>
                    </div>

                    <div class="overflow-x-auto p-4  ">
                        <table class="w-full text-sm text-left">
                            <thead class="text-md text-white uppercase bg-fondo dark:bg-gray-700 dark:text-gray-300">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Nombre</th>
                                    <th scope="col" class="px-4 py-3">Sigla</th>
                                    <th scope="col" class="px-4 py-3">Estado</th>
                                    <th scope="col" class="px-4 py-3">Docente</th>
                                    <th scope="col" class="px-4 py-3">Cant. Estudiantes</th>
                                    <th scope="col" class="px-4 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($users as $user)
                                <tr
                                    class="border-b dark:border-gray-700 @if ($loop->even) bg-gray-100 dark:bg-gray-800 @endif">
                                    <th scope="row"
                                        class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $user->nombre }}
                                    </th>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $user->apellido }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $user->email }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $user->cargo->nombre }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $user->area->nombre }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        @foreach ($user->getRoleNames() as $rol)
                                            {{ $rol }}
                                        @endforeach
                                    </td>
                                    <td class="flex items-center justify-end">
                                        <x-shared.button icon="edit" route="user.edit" color="blue" type="a"
                                            :params="$user->id" />
                                        <x-shared.button icon="delete" color="red" type="button"
                                            :params="$user->id" />
                                    </td>
                                </tr>
                            @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </section>

            </section>
        </div>
    </x-shared.container>
</div>
