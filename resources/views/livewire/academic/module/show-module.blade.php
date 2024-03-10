<div>
    <x-shared.container :breadcrumbs="$breadcrumbs">
        <div class="relative overflow-hidden bg-white  dark:bg-gray-800 sm:rounded-lg">
            <div class="flex-row items-center justify-between p-4 space-y-3 sm:flex sm:space-y-0 sm:space-x-4">
                <div>
                    <h5 class="mr-3 text-lg font-bold dark:text-white uppercase">{{ $module->nombre }}</h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Datos del modulo</p>
                </div>
                <div class="flex items-center space-x-3">
                    <x-shared.button-header title="Volver" route="module.list" :params="[$module->id]" />
                    <x-shared.button-header title="Editar" route="module.edit" :params="[$module->id]" />

                </div>
            </div>
        </div>

        <div class="max-w px-4 py-8 mx-auto">
            <section>
                <div class="grid gap-4 mb-4 sm:grid-cols-3 sm:gap-6 sm:mb-5">
                    <x-shared.input-readonly title="Codigo" :value="$module->codigo" />
                    <x-shared.input-readonly title="Nombre" :value="$module->nombre" col='2' />

                    <x-shared.input-readonly title="Programa" :value="$program->nombre" col='2' />
                    <x-shared.input-readonly title="Docente" :value="$teacher->honorifico . ' ' . $teacher->nombre . ' ' . $teacher->apellido" />


                    <x-shared.input-readonly title="Sigla" :value="$module->sigla . ' - ' . $module->version . '.' . $module->edicion" />
                    <x-shared.input-readonly title="Modalidad" :value="$module->modalidad" />
                    <x-shared.input-readonly title="Estado" :value="$module->estado" />

                    <x-shared.input-readonly title="Fecha Inicio" :value="\Carbon\Carbon::parse($module->fecha_inicio)->format('d/m/Y')" />
                    <x-shared.input-readonly title="Fecha Final" :value="\Carbon\Carbon::parse($module->fecha_final)->format('d/m/Y')" />
                    <x-shared.space />

                    <x-shared.input-readonly title="Costo" :value="$module->costo" />
                    <x-shared.input-readonly title="Hrs Academicas" :value="$module->hrs_academicas" />
                    <x-shared.input-readonly title="Calificacion Docente" :value="$module->calificacion_docente" />

                    <x-shared.input-readonly title="Contenido" :value="$module->contenido" col='3' />
                </div>

                <section class="mt-4">
                    <div class="flex items">
                        <h5 class="text-lg font-bold dark:text-white uppercase">Procesos</h5>
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

                <section class="mt-4">
                    <div class="flex items">
                        <h5 class="text-lg font-bold dark:text-white uppercase">Estudiantes</h5>
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
