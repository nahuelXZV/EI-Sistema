<div>
    <x-shared.container :breadcrumbs="$breadcrumbs">
        <div class="relative overflow-hidden bg-white  dark:bg-gray-800 sm:rounded-lg">
            <div class="flex-row items-center justify-between p-4 space-y-3 sm:flex sm:space-y-0 sm:space-x-4">
                <div>
                    <h5 class="mr-3 text-lg font-bold dark:text-white uppercase">
                        {{ $support->nombre }}</h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Datos del soporte</p>
                </div>
                <div class="flex items-center space-x-3">
                    <x-shared.button-header title="Volver" route="support.list" :params="[$support->id]" />
                    <x-shared.button-header title="Editar" route="support.edit" :params="[$support->id]" />
                    @if($support->recurso)
                        <a type="button" href="{{asset($support->recurso)}}"
                            class="w-min flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-fondo hover:bg-primary-900 focus:ring-4 focus:ring-fondo dark:bg-fondo dark:hover:bg-primary-900 focus:outline-none dark:focus:ring-primary-800">
                            Recurso
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="max-w px-4 py-8 mx-auto">
            <section>
                <div class="grid gap-4 mb-4 sm:grid-cols-3 sm:gap-6 sm:mb-5">
                    <div class="grid gap-4 mb-4 col-span-3 sm:col-span-2 sm:grid-cols-6 sm:gap-6 sm:mb-5">
                        <x-shared.input-readonly title="Id" col='6' :value="$support->id" />
                        <x-shared.input-readonly title="Motivo" col='6' :value="$support->motivo" />
                        <x-shared.input-readonly title="Fecha" col='3' :value="$support->fecha" />
                        <x-shared.input-readonly title="Hora" col='3' :value="$support->hora" />
                        <x-shared.input-readonly title="Estado" col='3' :value="$support->estado" />
                        <x-shared.input-readonly title="Descripcion" col='6' :value="$support->descripcion" />
                        @if ($support->fecha_visita)
                            <x-shared.input-readonly title="Fecha Visita" col='3' :value="$support->fecha_visita" />
                        @endif
                        @if ($support->user_id)
                            <x-shared.input-readonly title="Usuario" col='3' :value="$support->name_user . ' ' . $support->lastname_user" />
                        @endif
                    </div>
                    <nav class="px-1 py-3"> </nav>
                </div>
            </section>
        </div>
    </x-shared.container>
</div>
