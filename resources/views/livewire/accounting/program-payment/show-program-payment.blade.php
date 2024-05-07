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
                    <x-shared.button-header title="Volver" route="program-payment.list" :params="[$student->id]" />
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
                    </div>
                    <div class="grid gap-4 mb-4 col-span-3 sm:col-span-2 sm:grid-cols-6 sm:gap-6 sm:mb-5">
                        <x-shared.input-readonly title="Nombre" col='6' :value="$student->honorifico . ' ' . $student->nombre . ' ' . $student->apellido" />
                        <x-shared.input-readonly title="Cedula" col='3' :value="$student->cedula . ' - ' . $student->expedicion" />
                        <x-shared.input-readonly title="Nacionalidad" col='3' :value="$student->nacionalidad" />
                        @if ($student->nro_registro)
                            <x-shared.input-readonly title="Registro" col='3' :value="$student->nro_registro" />
                        @endif
                        @if ($student->telefono)
                            <x-shared.input-readonly title="Telefono" col='3' :value="$student->telefono" />
                        @endif
                        @if ($student->correo)
                            <x-shared.input-readonly title="Correo" col='3' :value="$student->correo" />
                        @endif
                    </div>
                    <nav class="px-1 py-3"> </nav>
                </div>


                <div class="flex items-center justify-between mt-5">
                    <h5 class="text-lg font-bold dark:text-white uppercase">Pago de programas</h5>
                </div>

                <div class="overflow-x-auto p-4  ">
                    <table class="w-full text-sm text-left">
                        <thead class="text-md text-white uppercase bg-fondo dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th scope="col" class="px-4 py-3">Nombre</th>
                                <th scope="col" class="px-4 py-3">Sigla</th>
                                <th scope="col" class="px-4 py-3">Costo</th>
                                <th scope="col" class="px-4 py-3">Estado</th>
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
                                        {{ $payment->nombre }}</td>
                                    <th scope="row"
                                        class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $payment->sigla . ' - ' . $payment->version . '.' . $payment->edicion }}
                                        </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $payment->costo . ' Bs.' }}
                                    </td>
                                    <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        @if ($payment->estado == 'Pagado')
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-white bg-green-400 rounded-full dark:bg-green-500 dark:text-green-300">
                                                Pagado
                                            </span>
                                        @else
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-white bg-blue-400 rounded-full dark:bg-blue-500 dark:text-blue-300">
                                                {{ $payment->estado }}
                                            </span>
                                        @endif
                                    </td>
                                    <td
                                        class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white flex items-center justify-end">
                                        <x-shared.button icon="show" route="pay.show" color="green" type="a"
                                            :hover="600" :params="['program', $payment->id]" tonality="400" />
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
    </x-shared.container>
</div>
