<div>
    <x-shared.container :breadcrumbs="$breadcrumbs">
        <div class="relative overflow-hidden bg-white  dark:bg-gray-800 sm:rounded-lg">
            <div class="flex-row items-center justify-between p-4 space-y-3 sm:flex sm:space-y-0 sm:space-x-4">
                <div>
                    <h5 class="mr-3 text-lg font-bold dark:text-white uppercase"> Editar Pago de Programa</h5>
                </div>
                <div class="flex items-center space-x-3">
                    <x-shared.button-header title="Volver" route="pay.show" :params="['program', $payment->id]" />
                    <button wire:click="save" wire:loading.attr="disabled"
                        class="w-min flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-fondo hover:bg-primary-900 focus:ring-4 focus:ring-fondo dark:bg-fondo dark:hover:bg-primary-900 focus:outline-none dark:focus:ring-primary-800">
                        Guardar
                    </button>
                </div>
            </div>
        </div>

        <div class="max-w px-4 py-8 mx-auto">
            <section>
                <div class="grid gap-4 mb-4 sm:grid-cols-3 sm:gap-6 sm:mb-5">
                    <div class="col-span-3 sm:col-span-1 mb-5">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Convalidacion
                        </label>
                        <input type="number" wire:model="paymentArray.convalidacion" min="0" step="0.01"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="0">
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
                    </div>
                    <nav class="px-1 py-3"> </nav>

                    <div class="col-span-3 sm:col-span-1 mb-5">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Subir
                            Comprobante
                        </label>
                        <input type="file" wire:model.live="voucher"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    </div>
                </div>
            </section>
        </div>
    </x-shared.container>
</div>
