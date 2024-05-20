<div>
    <x-shared.container :breadcrumbs="$breadcrumbs">
        <div class="relative overflow-hidden bg-white  dark:bg-gray-800 sm:rounded-lg">
            <div class="flex-row items-center justify-between p-4 space-y-3 sm:flex sm:space-y-0 sm:space-x-4">
                <div>
                    <h5 class="mr-3 text-lg font-bold dark:text-white uppercase">Editar</h5>
                </div>
                <button wire:click="save" type="button"
                    class="w-min flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-fondo hover:bg-primary-900 focus:ring-4 focus:ring-fondo dark:bg-fondo dark:hover:bg-primary-900 focus:outline-none dark:focus:ring-primary-800">
                    Guardar
                </button>
            </div>
        </div>

        <div class="max-w px-4 py-8 mx-auto">
            <section>
                <div class="grid gap-4 mb-4 sm:grid-cols-3 sm:gap-6 sm:mb-5">
                    @if (auth()->user()->can('soporte.index'))
                        <div class="col-span-3 sm:col-span-1">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha Visita
                            </label>
                            <input type="date" wire:model="requestArray.fecha_visita"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="0" required>
                            @error('requestArray.fecha_visita')
                                <x-shared.validate-error :message="$message" />
                            @enderror
                        </div>

                        <div class="col-span-3 sm:col-span-1">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                            <select wire:model.blur="requestArray.estado"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option selected="" value="">Seleccione un estado</option>
                                @foreach ($stateSupportRequest as $state)
                                    <option value="{{ $state }}">{{ $state }}</option>
                                @endforeach
                            </select>
                            @error('requestArray.estado')
                                <x-shared.validate-error :message="$message" />
                            @enderror
                        </div>
                    @else
                        <div class="col-span-3 sm:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Motivo
                            </label>
                            <input type="text" wire:model.blur="requestArray.motivo"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Motivo" required="">
                            @error('requestArray.motivo')
                                <x-shared.validate-error :message="$message" />
                            @enderror
                        </div>
                        <x-shared.space />
                        <div class="col-span-3 sm:col-span-1">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha
                            </label>
                            <input type="date" wire:model="requestArray.fecha"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="0" required>
                            @error('requestArray.fecha')
                                <x-shared.validate-error :message="$message" />
                            @enderror
                        </div>
                        <div class="">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hora
                            </label>
                            <input type="time" wire:model="requestArray.hora"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="0" required>
                            @error('requestArray.hora')
                                <x-shared.validate-error :message="$message" />
                            @enderror
                        </div>
                        <div class="col-span-3 sm:col-span-2">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Descripcion
                            </label>
                            <textarea rows="4" wire:model.blur="requestArray.descripcion"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Descripcion.."></textarea>
                            @error('requestArray.descripcion')
                                <x-shared.validate-error :message="$message" />
                            @enderror
                        </div>
                        <x-shared.space />
                        <div class="col-span-3 sm:col-span-1">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Subir recurso
                            </label>
                            <input type="file" wire:model.blur="recurso" accept="image/*"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            @error('recurso')
                                <x-shared.validate-error :message="$message" />
                            @enderror
                        </div>
                        <x-shared.space />
                        <x-shared.space />
                    @endif
                </div>
            </section>
        </div>
    </x-shared.container>
</div>
