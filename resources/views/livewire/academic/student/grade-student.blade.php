<div>
    <x-shared.container :breadcrumbs="$breadcrumbs">
        <div class="relative overflow-hidden bg-white  dark:bg-gray-800 sm:rounded-lg">
            <div class="flex-row items-center justify-between p-4 space-y-3 sm:flex sm:space-y-0 sm:space-x-4">
                <div>
                    <h5 class="mr-3 text-lg font-bold dark:text-white uppercase">{{ $program->nombre }}</h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Datos del programa</p>
                </div>
                <div class="flex items-center space-x-3">
                    <x-shared.button-header title="Volver" route="student.show" :params="[$student->id]" />
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
                </div>

                <div class="overflow-x-auto p-4  ">
                    <table class="w-full text-sm text-left">
                        <thead class="text-md text-white uppercase bg-fondo dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th scope="col" class="px-4 py-3">Codigo</th>
                                <th scope="col" class="px-4 py-3">Nombre</th>
                                <th scope="col" class="px-4 py-3">Sigla</th>
                                <th scope="col" class="px-4 py-3">Modalidad</th>
                                <th scope="col" class="px-4 py-3">Costo</th>
                                <th scope="col" class="px-4 py-3">Observaciones</th>
                                <th scope="col" class="px-4 py-3">Nota</th>
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
                                        {{ $module->modalidad }}
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $module->costo . ' Bs.' }}
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $module->observaciones }}
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        @if ($module->nota == 0)
                                            <span class="">S/N</span>
                                        @else
                                            @if ($module->nota < 51)
                                                <span
                                                    class="bg-red-500 text-white px-2 py-1 rounded">{{ $module->nota }}</span>
                                            @else
                                                <span class="bg-green-500 text-white px-2 py-1 rounded">
                                                    {{ $module->nota }}
                                                </span>
                                            @endif
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
