<div>
    <x-shared.container :breadcrumbs="$breadcrumbs">
        <div class="relative overflow-hidden bg-white  dark:bg-gray-800 sm:rounded-lg">
            <div class="flex-row items-center justify-between p-4 space-y-3 sm:flex sm:space-y-0 sm:space-x-4">
                <div>
                    <h5 class="mr-3 text-lg font-bold dark:text-white uppercase">{{ $module->nombre }}</h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Datos del modulo</p>
                </div>
                <div class="flex items-center space-x-3">
                    <x-shared.button-header title="Volver" route="program.show" :params="[$module->programa_id]" />
                    <x-shared.button-header title="Editar" route="module.edit" :params="[$module->id]" />
                    <x-shared.button-header title="Inscribir" route="module.inscription" :params="[$module->id]" />
                    <x-shared.button-header title="Notas" route="module.grade" :params="[$module->id]" />
                    @if ($module->estado == 'En proceso')
                        <x-shared.button-header title="Finalizar" type="button" clickAction="finishModule" />
                    @elseif ($module->estado != 'Finalizado')
                        <x-shared.button-header title="Iniciar" type="button" clickAction="initModule" />
                    @endif
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
                                    <th scope="col" class="px-4 py-3">Fecha</th>
                                    <th scope="col" class="px-4 py-3">Estado</th>
                                    <th scope="col" class="px-4 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($processes as $process)
                                    <tr
                                        class="border-b dark:border-gray-700 @if ($loop->even) bg-gray-100 dark:bg-gray-800 @endif">
                                        <th scope="row"
                                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $process['nombre'] }}
                                        </th>
                                        <td
                                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ \Carbon\Carbon::parse($process['fecha'])->format('d/m/Y') }}
                                        </td>
                                        <td
                                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            @if ($process['estado'] == 'true')
                                                <span class="bg-green-500 text-white px-2 py-1 rounded">Realizado</span>
                                            @else
                                                <span class="bg-red-500 text-white px-2 py-1 rounded">Sin
                                                    realizar</span>
                                            @endif
                                        </td>
                                        <td
                                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white flex items-center justify-end">
                                            @if (!$process['fecha'])
                                                <x-shared.button color="green" icon='done' :params="$process['id']"
                                                    type="button" action='process' tonality="400" />
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
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
                                    <th scope="col" class="px-4 py-3">Foto</th>
                                    <th scope="col" class="px-4 py-3">Nombre</th>
                                    <th scope="col" class="px-4 py-3">Observaciones</th>
                                    <th scope="col" class="px-4 py-3">Nota</th>
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
                                        <td
                                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $student->honorifico . ' ' . $student->nombre . ' ' . $student->apellido }}
                                        </td>
                                        <td
                                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $student->observacion ?? 'Sin observaciones' }}
                                        </td>
                                        <td>
                                            @if ($student->nota == 0)
                                                <span class="">S/N</span>
                                            @else
                                                @if ($student->nota < 51)
                                                    <span
                                                        class="bg-red-500 text-white px-2 py-1 rounded">{{ $student->nota }}</span>
                                                @else
                                                    <span class="bg-green-500 text-white px-2 py-1 rounded">
                                                        {{ $student->nota }}
                                                    </span>
                                                @endif
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
            </section>
        </div>
    </x-shared.container>
</div>
