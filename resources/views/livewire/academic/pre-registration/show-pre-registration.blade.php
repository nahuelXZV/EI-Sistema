<div>
    <x-shared.container :breadcrumbs="$breadcrumbs">
        <div class="relative overflow-hidden bg-white  dark:bg-gray-800 sm:rounded-lg">
            <div class="flex-row items-center justify-between p-4 space-y-3 sm:flex sm:space-y-0 sm:space-x-4">
                <div>
                    <h5 class="mr-3 text-lg font-bold dark:text-white uppercase">
                        {{ $registration->honorifico . ' ' . $registration->nombre . ' ' . $registration->apellido }}
                    </h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Datos del estudiante</p>
                </div>
                <div class="flex items-center space-x-3">
                    <x-shared.button-header title="Volver" route="preregistration.list" />
                    <x-shared.button-header title="Aprobar" type='button' clickAction="approve" />
                </div>
            </div>
        </div>

        <div class="max-w px-4 py-8 mx-auto">
            <section>
                <div class="grid gap-4 mb-4 sm:grid-cols-3 sm:gap-6 sm:mb-5">
                    <div class="col-span-3 sm:col-span-1">
                        <div class="flex items center justify-center">
                            <img class="w-40 h-auto rounded-sm"
                                src="{{ $registration->foto ? asset($registration->foto) : asset('img/user.png') }}"
                                alt="{{ $registration->nombre }}">
                            <br>
                        </div>
                        <div class="flex items center justify-center mt-4">
                            <div>
                                <p class="font-semibold">Comprobante de Pre Registro</p>
                                <div class="mt-2">
                                    <x-shared.button-header title="Ver Comprobante" :route="$registration->comprobante_pago" type="download" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid gap-4 mb-4 col-span-3 sm:col-span-2 sm:grid-cols-6 sm:gap-6 sm:mb-5">
                        <x-shared.input-readonly title="Nombre" col='6' :value="$registration->honorifico .
                            ' ' .
                            $registration->nombre .
                            ' ' .
                            $registration->apellido" />
                        <x-shared.input-readonly title="Cedula" col='3' :value="$registration->cedula . ' - ' . $registration->expedicion" />
                        <x-shared.input-readonly title="Nacionalidad" col='3' :value="$registration->nacionalidad" />
                        <x-shared.input-readonly title="Universidad" col='3' :value="$university->nombre" />
                        <x-shared.input-readonly title="Carrera" col='3' :value="$carrer->nombre" />
                        @if ($registration->nro_registro)
                            <x-shared.input-readonly title="Registro" col='3' :value="$registration->nro_registro" />
                        @endif
                        @if ($registration->telefono)
                            <x-shared.input-readonly title="Telefono" col='3' :value="$registration->telefono" />
                        @endif
                        @if ($registration->correo)
                            <x-shared.input-readonly title="Correo" col='3' :value="$registration->correo" />
                        @endif

                        <x-shared.input-readonly title="Programa" col='6' :value="$program->nombre" />
                        @if ($discount)
                            <x-shared.input-readonly title="Descuento" col='3' :value="$discount->nombre" />
                        @endif

                    </div>
                    <nav class="px-1 py-3"> </nav>
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
