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
                    <x-shared.button-header title="Volver" route="teacher.show" :params="[$teacher->id]" />
                    @if ($contract->dir_comprobante)
                        <x-shared.button-header title="Descargar Comprobante" :route="$contract->dir_comprobante" type='download' />
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
                    </div>
                    <div class="grid gap-4 mb-4 col-span-3 sm:col-span-2 sm:gap-6 sm:mb-5">
                        <x-shared.input-readonly title="Nombre" col='3' :value="$teacher->honorifico . ' ' . $teacher->nombre . ' ' . $teacher->apellido" />
                        <x-shared.input-readonly title="Cedula" col='3' :value="$teacher->cedula . ' - ' . $teacher->expedicion" />
                        @if ($contract->modulo_id)
                            <x-shared.input-readonly title="Modulo" col='3' :value="$module->nombre" />
                        @endif
                        @if ($contract->curso_id)
                            <x-shared.input-readonly title="Curso" col='3' :value="$course->nombre" />
                        @endif
                    </div>
                </div>

                <section>
                    <div class="flex items-center justify-between mt-5">
                        <h5 class="text-lg font-bold dark:text-white uppercase">Cartas</h5>
                    </div>
                    <div class="overflow-x-auto p-4  ">
                        <table class="w-full text-sm text-left">
                            <thead class="text-md text-white uppercase bg-fondo dark:bg-gray-700 dark:text-gray-300">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Nombre</th>
                                    <th scope="col" class="px-4 py-3">Fecha Creacion</th>
                                    <th scope="col" class="px-4 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($letters as $letter)
                                    <tr
                                        class="border-b dark:border-gray-700 @if ($loop->even) bg-gray-100 dark:bg-gray-800 @endif">
                                        <th scope="row"
                                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $letter->nombre }}
                                        </th>
                                        <th scope="row"
                                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $letter->fecha_carta }}
                                        </th>
                                        </td>
                                        <td class="flex items-center justify-end">
                                            <x-shared.button icon="show" :route="$letter->ruta" color="green"
                                                type="a" :params="$letter->id" />

                                            @if ($letter->fecha_carta)
                                                <x-shared.button icon="download" route="letter.download" color="blue"
                                                    type="download" :params="[
                                                        'letter' => $letter->id,
                                                        'type' => $letter->nombre,
                                                    ]" />
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

            </section>
        </div>
    </x-shared.container>
</div>
