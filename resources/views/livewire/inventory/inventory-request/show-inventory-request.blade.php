<div>
    <x-shared.container :breadcrumbs="$breadcrumbs">
        <div class="relative overflow-hidden bg-white  dark:bg-gray-800 sm:rounded-lg">
            <div class="flex-row items-center justify-between p-4 space-y-3 sm:flex sm:space-y-0 sm:space-x-4">
                <div>
                    <h5 class="mr-3 text-lg font-bold dark:text-white uppercase">
                        Datos de la solicitud de inventario
                    </h5>
                </div>
                <div class="flex items-center space-x-3">
                    <x-shared.button-header title="Volver" route="inventory-request.list" />
                    @if ($request->estado == 'Pendiente' && auth()->user()->can('solicitudes.index'))
                        <x-shared.button-header title="Aprobar" type="button" clickAction="updateState" />
                        <x-shared.button-header title="Rechazar" route="inventory-request.edit" :params="$request->id" />
                    @endif
                </div>
            </div>
        </div>

        <div class="max-w px-4 py-8 mx-auto">
            <section>
                <div class="grid gap-4 mb-4 col-span-3 sm:col-span-2 sm:grid-cols-6 sm:gap-6 sm:mb-5">
                    <x-shared.input-readonly title="Usuario" col='6' :value="$request->name_user . ' ' . $request->lastname_user" />
                    <x-shared.input-readonly title="Fecha" col='2' :value="$request->fecha" />
                    <x-shared.input-readonly title="Hora" col='2' :value="$request->hora" />
                    <x-shared.input-readonly title="Estado" col='2' :value="$request->estado" />
                    @if ($request->motivo_rechazo)
                        <x-shared.input-readonly title="Motivo Rechazo" col='3' :value="$request->motivo_rechazo" />
                    @endif
                </div>

                <div class="flex items-center justify-between mt-5">
                    <h5 class="text-lg font-bold dark:text-white uppercase">Detalle</h5>
                </div>

                <div class="overflow-x-auto p-4  ">
                    <table class="w-full text-sm text-left">
                        <thead class="text-md text-white uppercase bg-fondo dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th scope="col" class="px-4 py-3">Foto</th>
                                <th scope="col" class="px-4 py-3">Codigo Partida</th>
                                <th scope="col" class="px-4 py-3">Nombre</th>
                                <th scope="col" class="px-4 py-3">Cantidad</th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $detail)
                                <tr
                                    class="border-b dark:border-gray-700 @if ($loop->even) bg-gray-100 dark:bg-gray-800 @endif">
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items">
                                            <img class="w-10 h-10" src="{{ asset($detail->foto) }}">
                                        </div>
                                    </td>
                                    <th scope="row"
                                        class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $detail->codigo_partida }}
                                        </td>
                                    <th scope="row"
                                        class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $detail->name_product }}
                                        </td>
                                    <th scope="row"
                                        class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $detail->cantidad }}
                                        </td>
                                    <td
                                        class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white flex items-center justify-end">
                                        @if ($request->estado == 'Pendiente' && ($request->user_id == auth()->user()->id || auth()->user()->can('eliminar')))
                                            <x-shared.button icon="delete" color="red" type="button"
                                                :params="$detail->id" action="delete" />
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        @if ($notificacion)
            <x-shared.notificacion :message="$message" :type="$type" />
            @script
                <script>
                    setTimeout(() => {
                        $wire.dispatch('cleanerNotificacion');
                    }, 3500);
                </script>
            @endscript
        @endif
    </x-shared.container>
</div>
