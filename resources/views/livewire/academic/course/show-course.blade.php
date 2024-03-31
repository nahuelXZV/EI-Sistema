<div>
    <x-shared.container :breadcrumbs="$breadcrumbs">
        <div class="relative overflow-hidden bg-white  dark:bg-gray-800 sm:rounded-lg">
            <div class="flex-row items-center justify-between p-4 space-y-3 sm:flex sm:space-y-0 sm:space-x-4">
                <div>
                    <h5 class="mr-3 text-lg font-bold dark:text-white uppercase">{{ $course->nombre }}</h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Datos del curso</p>
                </div>
                <div class="flex items-center space-x-3">
                    <x-shared.button-header title="Volver" route="course.list" :params="[$course->id]" />
                    <x-shared.button-header title="Editar" route="course.edit" :params="[$course->id]" />
                    <x-shared.button-header title="Inscribir" route="course.inscription" :params="[$course->id]" />
                    <x-shared.button-header title="Notas" route="course.grade" :params="[$course->id]" />
                </div>
            </div>
        </div>

        <div class="max-w px-4 py-8 mx-auto">
            <section>
                <div class="grid gap-4 mb-4 sm:grid-cols-3 sm:gap-6 sm:mb-5">
                    <x-shared.input-readonly title="Nombre" :value="$course->nombre" col='2' />
                    <x-shared.space />
                    <x-shared.input-readonly title="Horario" :value="$course->horario" />
                    <x-shared.input-readonly title="Horas Academicas" :value="$course->hrs_academicas" />
                    <x-shared.input-readonly title="Costo" :value="$course->costo" />
                    <x-shared.input-readonly title="Modalidad" :value="$course->modalidad" />
                    <x-shared.input-readonly title="Fecha Inicio" :value="\Carbon\Carbon::parse($course->fecha_inicio)->format('d/m/Y')" />
                    <x-shared.input-readonly title="Fecha Final" :value="\Carbon\Carbon::parse($course->fecha_final)->format('d/m/Y')" />
                    <x-shared.space />
                </div>

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
