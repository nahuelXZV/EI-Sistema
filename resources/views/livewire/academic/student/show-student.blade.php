<div>
    <x-shared.container :breadcrumbs="$breadcrumbs">
        <div class="relative overflow-hidden bg-white  dark:bg-gray-800 sm:rounded-lg">
            <div class="flex-row items-center justify-between p-4 space-y-3 sm:flex sm:space-y-0 sm:space-x-4">
                <div>
                    <h5 class="mr-3 text-lg font-bold dark:text-white uppercase">
                        {{ $student->honorifico . ' ' . $student->nombre . ' ' . $student->apellido }}</h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Datos del estudiante</p>
                </div>
                <div class="flex items-center space-x-3">
                    <x-shared.button-header title="Volver" route="student.list" :params="[$student->id]" />
                    <x-shared.button-header title="Editar" route="student.edit" :params="[$student->id]" />
                    <x-shared.button-header title="Inscribir" route="student.edit" :params="[$student->id]" />
                </div>
            </div>
        </div>

        <div class="max-w px-4 py-8 mx-auto">
            <section>
                <div class="grid gap-4 mb-4 sm:grid-cols-3 sm:gap-6 sm:mb-5">
                    <div class="col-span-3 sm:col-span-1">
                        <div class="flex items center justify-center">
                            <img class="w-40 h-auto rounded-sm"
                                src="{{ $student->foto ? asset($student->foto) : asset('img/user.png') }}"
                                alt="{{ $student->nombre }}">
                            <br>
                        </div>
                        <div class="flex items center justify-center mt-3">
                            <input type="checkbox" wire:click="changeState" @checked($student->estado == 'activo')
                                class="form-checkbox h-5 w-5 text-blue-600">
                            <label for="factura" class="ml-2 text-gray-700 dark:text-gray-300">
                                Estado
                            </label>
                        </div>
                        <div class="flex items center justify-center">
                            <x-shared.span :text="'Tickeado si el estudiante esta activo'" />
                        </div>
                    </div>
                    <div class="grid gap-4 mb-4 col-span-3 sm:col-span-2 sm:grid-cols-6 sm:gap-6 sm:mb-5">
                        <x-shared.input-readonly title="Nombre" col='6' :value="$student->honorifico . ' ' . $student->nombre . ' ' . $student->apellido" />
                        <x-shared.input-readonly title="Cedula" col='3' :value="$student->cedula . ' - ' . $student->expedicion" />
                        <x-shared.input-readonly title="Nacionalidad" col='3' :value="$student->nacionalidad" />
                        <x-shared.input-readonly title="Universidad" col='3' :value="$student->universidad" />
                        <x-shared.input-readonly title="Carrera" col='3' :value="$student->carrera" />
                        @if ($student->nro_registro)
                            <x-shared.input-readonly title="Registro" col='3' :value="$student->nro_registro" />
                        @endif
                        @if ($student->telefono)
                            <x-shared.input-readonly title="Telefono" col='3' :value="$student->telefono" />
                        @endif
                        @if ($student->correo)
                            <x-shared.input-readonly title="Correo" col='3' :value="$student->correo" />
                        @endif
                        @if ($student->fecha_inactividad)
                            <x-shared.input-readonly title="Fecha Inactividad" col='3' :value="$student->fecha_inactividad" />
                        @endif
                    </div>
                </div>

                {{-- documentos --}}
                <section class="mt-5">
                    <div class="flex-row items-center justify-between space-y-3 sm:flex sm:space-y-0 sm:space-x-4">
                        <h5 class="text-lg font-bold dark:text-white uppercase">Documentos</h5>
                        <div class="flex items-center space-x-3">
                            <x-shared.button-header title="Agregar requisito" route="student.requirement"
                                :params="[$student->id]" />
                        </div>
                    </div>

                    <div class="overflow-x-auto p-4  ">
                        <table class="w-full text-sm text-left">
                            <thead class="text-md text-white uppercase bg-fondo dark:bg-gray-700 dark:text-gray-300">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Requisito</th>
                                    <th scope="col" class="px-4 py-3">Nombre documento</th>
                                    <th scope="col" class="px-4 py-3">Importancia</th>
                                    <th scope="col" class="px-4 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requirements as $requirement)
                                    <tr
                                        class="border-b dark:border-gray-700 @if ($loop->even) bg-gray-100 dark:bg-gray-800 @endif">
                                        <th scope="row"
                                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $requirement['nombre'] }}
                                        </th>
                                        <td
                                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $requirement['documento'] }}</td>
                                        <td
                                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $requirement['importancia'] }}</td>
                                        <td
                                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white flex items-center justify-end">
                                            <x-shared.button color="green" tonality="400" type='asset' icon="show"
                                                :params="$requirement['dir']" />
                                            <x-shared.button color="red" type='function' action='deleteRequirement'
                                                icon="delete" :params="$requirement['id']" />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

                {{-- programas --}}
                <section class="mt-5">
                    <div class="flex items">
                        <h5 class="text-lg font-bold dark:text-white uppercase">Programas inscritos</h5>
                    </div>
                    <div class="overflow-x-auto p-4  ">
                        <table class="w-full text-sm text-left">
                            <thead class="text-md text-white uppercase bg-fondo dark:bg-gray-700 dark:text-gray-300">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Codigo</th>
                                    <th scope="col" class="px-4 py-3">Nombre</th>
                                    <th scope="col" class="px-4 py-3">Sigla</th>
                                    <th scope="col" class="px-4 py-3">Modalidad</th>
                                    <th scope="col" class="px-4 py-3">Tipo</th>
                                    <th scope="col" class="px-4 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($programs as $program)
                                    <tr
                                        class="border-b dark:border-gray-700 @if ($loop->even) bg-gray-100 dark:bg-gray-800 @endif">
                                        <th scope="row"
                                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $program->codigo }}
                                        </th>
                                        <td
                                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $program->nombre }}</td>
                                        <td
                                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $program->sigla . ' - ' . $program->version . '.' . $program->edicion }}
                                        </td>
                                        <td
                                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $program->modalidad }}</td>
                                        <td
                                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $program->tipo }}</td>

                                        <td class="flex items-center justify-center">
                                            <x-shared.button icon="show" route="student.grade" color="green"
                                                type="a" :hover="600" :params="[$student->id, $program->id]" tonality="400" />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <nav class="px-1 py-3">
                            {{ $programs->links() }}
                        </nav>
                    </div>
                </section>
                {{-- pagos --}}
                <section class="mt-5">
                    <div class="flex items">
                        <h5 class="text-lg font-bold dark:text-white uppercase">Pagos</h5>
                    </div>
                    <div class="overflow-x-auto p-4  ">
                        <table class="w-full text-sm text-left">
                            <thead class="text-md text-white uppercase bg-fondo dark:bg-gray-700 dark:text-gray-300">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Nombre</th>
                                    <th scope="col" class="px-4 py-3">Sigla</th>
                                    <th scope="col" class="px-4 py-3">Estado</th>
                                    <th scope="col" class="px-4 py-3">Deuda</th>
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
