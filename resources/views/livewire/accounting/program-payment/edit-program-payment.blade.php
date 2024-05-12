<div>
    <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
        class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-fondo hover:bg-primary-900 focus:ring-4 focus:ring-primary-300 dark:bg-fondo dark:hover:bg-primary-900 focus:outline-none dark:focus:ring-primary-900"
        type="button">
        Editar
    </button>

    <!-- Main modal -->
    <div id="authentication-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Editar Pago de Programa
                    </h3>
                    <button type="button"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="authentication-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <div class="space-y-4">
                        <div class="">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Convalidacion
                            </label>
                            <input type="number" wire:model="paymentArray.convalidacion" min="0" step="0.01"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="0">
                            @error('paymentArray.convalidacion')
                                <x-shared.validate-error :message="$message" />
                            @enderror
                        </div>

                        <div class="col-span-3 sm:col-span-1 mb-5">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de
                                Descuento
                            </label>
                            <select wire:model="paymentArray.tipo_descuento_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option value="">Seleccione un descuento</option>
                                @foreach ($discounts as $descuento)
                                    <option value="{{ $descuento->id }}">
                                        {{ $descuento->nombre . ' | ' . $descuento->porcentaje . '%' }}</option>
                                @endforeach
                            </select>
                            @error('paymentArray.tipo_descuento_id')
                                <x-shared.validate-error :message="$message" />
                            @enderror
                        </div>

                        <button wire:click="save" wire:loading.attr="disabled"
                            class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-fondo hover:bg-primary-900 focus:ring-4 focus:ring-primary-300 dark:bg-fondo dark:hover:bg-primary-900 focus:outline-none dark:focus:ring-primary-900">
                            Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
