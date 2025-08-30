<div>
    <div class="relative overflow-hidden bg-white  dark:bg-gray-800 sm:rounded-lg">
        <div class="flex-row items-center justify-between p-4 space-y-3 sm:flex sm:space-y-0 sm:space-x-4">
            <div>
                <h5 class="mr-3 text-lg font-bold dark:text-white uppercase">
                    {{ $student->honorifico . ' ' . $student->nombre . ' ' . $student->apellido }}
                    -
                    @if ($payment->estado == 'SIN DEUDA' || $payment->estado == 'PAGADO')
                        <x-shared.badge color="green">{{ $payment->estado }} </x-shared.badge>
                    @else
                        <x-shared.badge color="red"> {{ $payment->estado }}</x-shared.badge>
                    @endif
                </h5>
                <p class="text-sm text-gray-500 dark:text-gray-400">Historial de pagos</p>
            </div>
            <div class="flex items-center space-x-3">
                <x-shared.button-header title="Volver" route="payment.show" :params="[$student->id]" />
                <x-shared.button-header title="Editar" route="payment.edit" :params="['program', $payment->id]" />
                <x-shared.button-header title="Nuevo Pago" route="pay.new" :params="['program', $payment->id]" />
                @if ($payment->comprobante)
                    <x-shared.button-header title="Comprobante" :route="$payment->comprobante" type="download" />
                @endif
                <x-shared.button-header type="downloadParams" title="PDF" route="payment.pdf" :params="['program', $payment->id]" />
            </div>
        </div>
    </div>

    <div class="max-w px-4 py-8 mx-auto">
        <section>
            <div class="flex items-center justify-between mb-4">
                <h5 class="text-lg font-bold dark:text-white uppercase">Datos del programa</h5>
            </div>
            <div class="grid gap-4 mb-4 sm:grid-cols-3 sm:gap-6 sm:mb-5">
                <x-shared.input-readonly title="Codigo" :value="$program->codigo" />
                <x-shared.input-readonly title="Nombre" :value="$program->nombre" col='2' />

                <x-shared.input-readonly title="Sigla" :value="$program->sigla . ' - ' . $program->version . '.' . $program->edicion" />
                <x-shared.input-readonly title="Tipo" :value="$program->tipo" />
                <x-shared.input-readonly title="Modalidad" :value="$program->modalidad" />

                @if ($discountApplied)
                    <x-shared.input-readonly title="Nombre descuento" :value="$discountApplied->nombre" />
                @endif
                <x-shared.input-readonly title="Fecha Inicio" :value="\Carbon\Carbon::parse($program->fecha_inicio)->format('d/m/Y')" />
                <x-shared.input-readonly title="Fecha Final" :value="\Carbon\Carbon::parse($program->fecha_final)->format('d/m/Y')" />
                @if (!$discountApplied)
                    <x-shared.space />
                @endif

                <x-shared.input-readonly title="Cantidad de modulos" :value="$program->cantidad_modulos" />
                <x-shared.input-readonly title="Cantidad de modulos en curso" :value="$numberModulesInProgress" />
                <x-shared.space />

                <x-shared.input-readonly title="Costo del programa" :value="$program->costo" />
                <x-shared.input-readonly title="Descuento" :value="$discount" />
                @if ($payment->convalidacion)
                    <x-shared.input-readonly title="Convalidacion" :value="$payment->convalidacion" />
                @endif
                <x-shared.input-readonly title="Monto total a pagar" :value="$amountTotal" />
            </div>

            <div class="flex items-center justify-between mt-5 mb-4">
                <h5 class="text-lg font-bold dark:text-white uppercase">Datos economicos</h5>
            </div>
            <div class="grid gap-4 mb-4 sm:grid-cols-4 sm:gap-6 sm:mb-5">
                <x-shared.input-readonly title="Monto Pagado" :value="$amountPaid" />
                <x-shared.input-readonly title="Monto adeudado hasta la fecha" :value="$amountOwed" />
                <x-shared.input-readonly title="Monto pagado hasta la fecha" :value="$amountPaid" />
                <x-shared.input-readonly title="Saldo total del programa" :value="$debt" />
            </div>

            <div class="flex items-center justify-between mt-5">
                <h5 class="text-lg font-bold dark:text-white uppercase">Detalle de pagos</h5>
            </div>

            <div class="overflow-x-auto p-4  ">
                <table class="w-full text-sm text-left">
                    <thead class="text-md text-white uppercase bg-fondo dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th scope="col" class="px-4 py-3">Comprobante</th>
                            <th scope="col" class="px-4 py-3">Metodo de Pago</th>
                            <th scope="col" class="px-4 py-3">Fecha de pago</th>
                            <th scope="col" class="px-4 py-3">Monto Pagado</th>
                            <th scope="col" class="px-4 py-3">Monto Acumulado</th>
                            <th scope="col" class="px-4 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $payment)
                            <tr
                                class="border-b dark:border-gray-700 @if ($loop->even) bg-gray-100 dark:bg-gray-800 @endif">
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <a href="{{ asset($payment->comprobante) }}" target="_blank">
                                        Descargar Comprobante
                                    </a>
                                </td>
                                <td scope="row"
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $payment->tipo_pago }}
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ \Carbon\Carbon::parse($payment->fecha)->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $payment->monto . ' Bs.' }}
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $payment->acumulado . ' Bs.' }}
                                </td>

                                <td
                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white flex items-center justify-end">
                                    @can('eliminar')
                                        <x-shared.button icon="delete" action="delete" color="red" type="button"
                                            :params="$payment->id" />
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav class="px-1 py-3">
                    {{ $payments->links() }}
                </nav>
            </div>

            <div class="flex items-center justify-between">
                <h5 class="text-lg font-bold dark:text-white uppercase">Modulos inscritos</h5>
            </div>

            <div class="overflow-x-auto p-4  ">
                <table class="w-full text-sm text-left">
                    <thead class="text-md text-white uppercase bg-fondo dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th scope="col" class="px-4 py-3">Codigo</th>
                            <th scope="col" class="px-4 py-3">Nombre</th>
                            <th scope="col" class="px-4 py-3">Sigla</th>
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
</div>
