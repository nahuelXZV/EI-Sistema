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
                        <x-shared.badge color="red">{{ $payment->estado }} </x-shared.badge>
                    @endif
                </h5>
                <p class="text-sm text-gray-500 dark:text-gray-400">Historial de pagos</p>
            </div>
            <div class="flex items-center space-x-3">
                <x-shared.button-header title="Volver" route="payment.show" :params="[$student->id]" />
                <x-shared.button-header title="Editar" route="payment.edit" :params="['course', $payment->id]" />
                <x-shared.button-header title="Nuevo Pago" route="pay.new" :params="['course', $payment->id]" />
                @if ($payment->comprobante)
                    <x-shared.button-header title="Comprobante" :route="$payment->comprobante" type="download" />
                @endif
                <x-shared.button-header type="downloadParams" title="PDF" route="payment.pdf" :params="['course', $payment->id]" />
            </div>
        </div>
    </div>

    <div class="max-w px-4 py-8 mx-auto">
        <section>
            <div class="flex items-center justify-between mb-4">
                <h5 class="text-lg font-bold dark:text-white uppercase">Datos del curso</h5>
            </div>
            <div class="grid gap-4 mb-4 sm:grid-cols-3 sm:gap-6 sm:mb-5">
                <x-shared.input-readonly title="Nombre" :value="$course->nombre" col='3' />

                <x-shared.input-readonly title="Modalidad" :value="$course->modalidad" />
                <x-shared.input-readonly title="Hrs. Academicas" :value="$course->hrs_academicas" />
                <x-shared.space />

                <x-shared.input-readonly title="Fecha Inicio" :value="\Carbon\Carbon::parse($course->fecha_inicio)->format('d/m/Y')" />
                <x-shared.input-readonly title="Fecha Final" :value="\Carbon\Carbon::parse($course->fecha_final)->format('d/m/Y')" />
                <x-shared.space />

                <x-shared.input-readonly title="Costo del curso" :value="$course->costo" />
                <x-shared.input-readonly title="Descuento" :value="$discount" />
                @if ($payment->convalidacion)
                    <x-shared.input-readonly title="Convalidacion" :value="$payment->convalidacion" />
                @endif
            </div>

            <div class="flex items-center justify-between mt-5 mb-4">
                <h5 class="text-lg font-bold dark:text-white uppercase">Datos economicos</h5>
            </div>
            <div class="grid gap-4 mb-4 sm:grid-cols-3 sm:gap-6 sm:mb-5">
                <x-shared.input-readonly title="Monto a pagar" :value="$amountTotal" />
                <x-shared.input-readonly title="Monto pagado hasta la fecha" :value="$amountPaid" />
                <x-shared.input-readonly title="Saldo total del curso" :value="$debt" />
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

        </section>
    </div>
</div>
