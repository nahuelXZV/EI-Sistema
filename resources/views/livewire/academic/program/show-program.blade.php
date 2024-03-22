<div>
    <x-shared.container :breadcrumbs="$breadcrumbs">
        <div class="relative overflow-hidden bg-white  dark:bg-gray-800 sm:rounded-lg">
            <div class="flex-row items-center justify-between p-4 space-y-3 sm:flex sm:space-y-0 sm:space-x-4">
                <div>
                    <h5 class="mr-3 text-lg font-bold dark:text-white uppercase">{{ $program->nombre }}</h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Datos del programa</p>
                </div>
                <div class="flex items-center space-x-3">
                    <x-shared.button-header title="Volver" route="program.list" :params="[$program->id]" />
                    <x-shared.button-header title="Editar" route="program.edit" :params="[$program->id]" />
                    <x-shared.button-header title="Inscribir" route="program.inscription" :params="[$program->id]" />
                    @if ($program->has_grafica)
                        <x-shared.button-header title="Desactivar Grafica" type='button' clickAction="toggleGraph" />
                    @else
                        <x-shared.button-header title="Activar Grafica" type='button' clickAction="toggleGraph" />
                    @endif
                </div>
            </div>
        </div>

        <div class="max-w px-4 py-8 mx-auto">
            <section>
                <div class="grid gap-4 mb-4 sm:grid-cols-3 sm:gap-6 sm:mb-5">
                    <x-shared.input-readonly title="Codigo" :value="$program->codigo" />
                    <x-shared.input-readonly title="Nombre" :value="$program->nombre" col='2' />

                    <x-shared.input-readonly title="Sigla" :value="$program->sigla . ' - ' . $program->version . '.' . $program->edicion" />
                    <x-shared.input-readonly title="Tipo" :value="$program->tipo" />
                    <x-shared.input-readonly title="Modalidad" :value="$program->modalidad" />

                    <x-shared.input-readonly title="Fecha Inicio" :value="\Carbon\Carbon::parse($program->fecha_inicio)->format('d/m/Y')" />
                    <x-shared.input-readonly title="Fecha Final" :value="\Carbon\Carbon::parse($program->fecha_final)->format('d/m/Y')" />
                    <x-shared.space />

                    <x-shared.input-readonly title="Cantidad de modulos" :value="$program->cantidad_modulos" />
                    <x-shared.input-readonly title="Cantidad de modulos en curso" :value="$program->cantidad_modulos" />
                </div>

                <div class="flex items-center justify-between mt-5">
                    <h5 class="text-lg font-bold dark:text-white uppercase">Modulos</h5>
                    <x-shared.button-header title="Nuevo" route="module.new" :params="[$program->id]" />
                </div>

                <div class="overflow-x-auto p-4  ">
                    <table class="w-full text-sm text-left">
                        <thead class="text-md text-white uppercase bg-fondo dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th scope="col" class="px-4 py-3">Codigo</th>
                                <th scope="col" class="px-4 py-3">Nombre</th>
                                <th scope="col" class="px-4 py-3">Sigla</th>
                                <th scope="col" class="px-4 py-3">Docente</th>
                                <th scope="col" class="px-4 py-3">Modalidad</th>
                                <th scope="col" class="px-4 py-3">Estado</th>
                                <th scope="col" class="px-4 py-3">Costo</th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($modules as $module)
                                <tr
                                    class="border-b dark:border-gray-700 @if ($loop->even) bg-gray-100 dark:bg-gray-800 @endif">
                                    <th scope="row"
                                        class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $module->codigo }}
                                    </th>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $module->nombre }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $module->sigla . ' - ' . $module->version . '.' . $module->edicion }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $module->teacher->honorifico . ' ' . $module->teacher->nombre . ' ' . $module->teacher->apellido }}
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $module->modalidad }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $module->estado }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $module->costo . ' Bs.' }}</td>

                                    <td
                                        class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white flex items-center justify-end">
                                        <x-shared.button icon="show" route="program.module" color="green"
                                            type="a" :hover="600" :params="$module->id" tonality="400" />
                                        <x-shared.button icon="edit" route="module.edit" color="blue"
                                            type="a" :hover="600" :params="$module->id" />
                                        <x-shared.button icon="delete" color="red" type="button"
                                            :params="$module->id" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <nav class="px-1 py-3">
                        {{ $modules->links() }}
                    </nav>
                </div>

                <div class="flex items mt-5">
                    <h5 class="text-lg font-bold dark:text-white uppercase">Estudiantes inscritos</h5>
                </div>

                <div class="overflow-x-auto p-4  ">
                    <table class="w-full text-sm text-left">
                        <thead class="text-md text-white uppercase bg-fondo dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th scope="col" class="px-4 py-3">Foto</th>
                                <th scope="col" class="px-4 py-3">Nombre</th>
                                <th scope="col" class="px-4 py-3">Cedula</th>
                                <th scope="col" class="px-4 py-3">Telefono</th>
                                <th scope="col" class="px-4 py-3">Correo</th>
                                <th scope="col" class="px-4 py-3">Estado</th>
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
                                        {{ $student->telefono }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $student->correo }}
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        @if ($student->estado == 'activo')
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-white bg-green-400 rounded-full dark:bg-green-500 dark:text-green-300">
                                                Activo
                                            </span>
                                        @else
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                                Inactivo
                                            </span>
                                        @endif
                                    </td>
                                    <td
                                        class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white flex items-center justify-end">
                                        <x-shared.button icon="show" route="student.show" color="green"
                                            type="a" :hover="600" :params="$student->id" tonality="400" />
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
