<div>
    <x-shared.container :breadcrumbs="$breadcrumbs">
        <div class="relative overflow-hidden bg-white  dark:bg-gray-800 sm:rounded-lg">
            <div class="flex-row items-center justify-between p-4 space-y-3 sm:flex sm:space-y-0 sm:space-x-4">
                <div>
                    <h5 class="mr-3 text-lg font-bold dark:text-white uppercase">
                        {{ $inventory->nombre }}</h5>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Datos del activo fijo</p>
                </div>
                <div class="flex items-center space-x-3">
                    <x-shared.button-header title="Volver" route="inventory.list" />
                    <x-shared.button-header title="Editar" route="inventory.edit" :params="[$inventory->id]" />
                </div>
            </div>
        </div>

        <div class="max-w px-4 py-8 mx-auto">
            <section>
                <div class="grid gap-4 mb-4 sm:grid-cols-3 sm:gap-6 sm:mb-5">
                    <div class="col-span-3 sm:col-span-1">
                        <div class="flex items center justify-center">
                            <img class="w-80 h-auto rounded-sm" src="{{ asset($inventory->foto) }}"
                                alt="{{ $inventory->nombre }}">
                            <br>
                        </div>
                    </div>
                    <div class="grid gap-4 mb-4 col-span-3 sm:col-span-2 sm:grid-cols-6 sm:gap-3 sm:mb-2">
                        <x-shared.input-readonly title="Codigo de partida" col='3' :value="$inventory->codigo_partida" />
                        <x-shared.input-readonly title="Codigo de catalogo" col='3' :value="$inventory->codigo_catalogo" />
                        <x-shared.input-readonly title="Nombre" col='6' :value="$inventory->nombre" />
                        <x-shared.input-readonly title="Tipo" col='3' :value="$inventory->tipo" />
                        @if ($inventory->modelo)
                            <x-shared.input-readonly title="Modelo" col='3' :value="$inventory->modelo" />
                        @endif
                        <x-shared.input-readonly title="Cantidad de contenedores" col='3' :value="$inventory->cantidad_contenedor" />
                        <x-shared.input-readonly title="Unidades por contenedor" col='3' :value="$inventory->unidades_contenedor" />
                        <x-shared.input-readonly title="Total Unidades" col='3' :value="$inventory->total_unidades" />
                        @if ($inventory->descripcion)
                            <x-shared.input-readonly title="Descripcion" col='6' :value="$inventory->descripcion" />
                        @endif
                    </div>
                    <nav class="px-1 py-3"> </nav>
                </div>
            </section>
        </div>
    </x-shared.container>
</div>
