<div>
    <x-shared.container :breadcrumbs="$breadcrumbs">
        <div class="relative overflow-hidden bg-white  dark:bg-gray-800 sm:rounded-lg">
            <div class="flex-row items-center justify-between p-4 space-y-3 sm:flex sm:space-y-0 sm:space-x-4">
                <div>
                    <h5 class="mr-3 text-md font-bold dark:text-white uppercase">
                        {{ $program->nombre }}
                    </h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Datos del programa </p>
                </div>
                <div class="flex items-center space-x-3">
                    <x-shared.button-header title="Volver" route="program-offer.list" :params="[$program->id]" />
                    <x-shared.button-header title="Pre-Registro" route="program-offer.create" :params="[$program->id]" />
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
                    <x-shared.input-readonly title="Cantidad de modulos en curso" :value="$numberModulesInProgress" />
                    <x-shared.space />
                </div>

                <div class="flex items-center justify-between mt-5">
                    <h5 class="text-lg font-bold dark:text-white uppercase">Modulos</h5>
                </div>

                <div class="overflow-x-auto p-4  ">
                    <table class="w-full text-sm text-left">
                        <thead class="text-md text-white uppercase bg-fondo dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th scope="col" class="px-4 py-3">Sigla</th>
                                <th scope="col" class="px-4 py-3">Nombre</th>
                                <th scope="col" class="px-4 py-3">Docente</th>
                                <th scope="col" class="px-4 py-3">Modalidad</th>
                                <th scope="col" class="px-4 py-3">Estado</th>
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
                                        {{ $module->sigla }}
                                    </th>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ Str::limit($module->nombre, 50) }}
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $module->teacher->honorifico . ' ' . $module->teacher->nombre . ' ' . $module->teacher->apellido }}
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $module->modalidad }}
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        @if ($module->estado != 'Finalizado')
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-white bg-blue-400 rounded-full dark:bg-blue-500 dark:text-blue-300">
                                                {{ $module->estado }}
                                            </span>
                                        @else
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-white bg-green-400 rounded-full dark:bg-green-500 dark:text-green-300">
                                                Finalizado
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <nav class="px-1 py-3 w-full ">
                    {{ $modules->links() }}
                </nav>

                <div class="flex items-center justify-between mt-5">
                    <h5 class="text-lg font-bold dark:text-white uppercase">Pre Registros</h5>
                </div>

                <div class="overflow-x-auto p-4">
                    <table class="w-full text-sm text-left">
                        <thead class="text-md text-white uppercase bg-fondo dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th scope="col" class="px-4 py-3">Foto</th>
                                <th scope="col" class="px-4 py-3">Nombre</th>
                                <th scope="col" class="px-4 py-3">Cedula</th>
                                <th scope="col" class="px-4 py-3">Telefono</th>
                                <th scope="col" class="px-4 py-3">Correo</th>
                                <th scope="col" class="px-4 py-3">Comprobante de Pago</th>
                                <th scope="col" class="px-4 py-3">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($preRegistrations as $registration)
                                <tr
                                    class="border-b dark:border-gray-700 @if ($loop->even) bg-gray-100 dark:bg-gray-800 @endif">
                                    <th scope="row"
                                        class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items">
                                            <img class="w-10 h-10"
                                                src="{{ $registration->foto ? asset($registration->foto) : asset('img/user.png') }}">
                                        </div>
                                    </th>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $registration->nombre }} {{ $registration->apellido }}
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $registration->cedula . ' ' . $registration->expedicion }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $registration->telefono }}
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $registration->correo }}
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <a href="{{ $registration->comprobante_pago ? asset($registration->comprobante_pago) : '#' }}"
                                            target="_blank">
                                            Ver Comprobante
                                        </a>
                                    </td>
                                    <td
                                        class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white flex items-center justify-end">
                                        <x-shared.button icon="edit" route="program-offer.edit" color="blue"
                                            type="a" :hover="600" :params="[$registration->programa_id, $registration->id]" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <nav class="px-1 py-3">
                    {{ $preRegistrations->links() }}
                </nav>

            </section>
        </div>
    </x-shared.container>
</div>
