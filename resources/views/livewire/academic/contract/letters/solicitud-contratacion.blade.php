<div>
    <x-shared.container :breadcrumbs="$breadcrumbs">
        <div class="relative overflow-hidden bg-white  dark:bg-gray-800 sm:rounded-lg">
            <div class="flex-row items-center justify-between p-4 space-y-3 sm:flex sm:space-y-0 sm:space-x-4">
                <div>
                    <h5 class="mr-3 text-lg font-bold dark:text-white uppercase">Crear</h5>
                </div>

                <div class="flex items-center space-x-3">
                    <x-shared.button-header title="Volver" route="contract.show" :params="[$letter->contrato_id]" />
                    <button wire:click="save" type="button"
                        class="w-min flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-fondo hover:bg-primary-900 focus:ring-4 focus:ring-fondo dark:bg-fondo dark:hover:bg-primary-900 focus:outline-none dark:focus:ring-primary-800">
                        Guardar
                    </button>
                </div>
            </div>
        </div>

        <div class="max-w px-4 py-8 mx-auto">
            <section>
                <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nro. de Oficio
                        </label>
                        <input type="text" wire:model="administrativeCode"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Nro. de Oficio">
                        @error('administrativeCode')
                            <x-shared.validate-error :message="$message" />
                        @enderror
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha
                        </label>
                        <input type="date" wire:model="dateLetter"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        @error('dateLetter')
                            <x-shared.validate-error :message="$message" />
                        @enderror
                    </div>
                    {{-- <x-shared.space />s --}}

                    {{-- table --}}

                    <section class="col-span-2 ">
                        <div class="overflow-x-auto ">
                            <table class="w-full text-sm text-left">
                                <thead
                                    class="text-md text-white uppercase bg-fondo dark:bg-gray-700 dark:text-gray-300">
                                    <tr>
                                        <th scope="col" class="px-4 py-3">CODIGO CATALOGO UNSPSC</th>
                                        <th scope="col" class="px-4 py-3">ENT</th>
                                        <th scope="col" class="px-4 py-3">DA</th>
                                        <th scope="col" class="px-4 py-3">UE</th>
                                        <th scope="col" class="px-4 py-3">CATEGORIA PROG</th>
                                        <th scope="col" class="px-4 py-3">FUENTE</th>
                                        <th scope="col" class="px-4 py-3">ORG</th>
                                        <th scope="col" class="px-4 py-3">PART</th>
                                        <th scope="col" class="px-4 py-3">DESCRIPCION</th>
                                        <th scope="col" class="px-4 py-3">IMPORTE (Bs.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b dark:border-gray-700  bg-gray-100 dark:bg-gray-800 ">
                                        <th scope="row"
                                            class="px-2 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <div>
                                                <input type="text" wire:model="parameters.codigo_catalogo"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="00">
                                                @error('parameters.codigo_catalogo')
                                                    <x-shared.validate-error :message="$message" />
                                                @enderror
                                            </div>
                                        </th>
                                        <th scope="row"
                                            class="px-2 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <div>
                                                <input type="text" wire:model="parameters.ent"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="00">
                                                @error('parameters.ent')
                                                    <x-shared.validate-error :message="$message" />
                                                @enderror
                                            </div>
                                        </th>
                                        <th scope="row"
                                            class="px-2 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <div>
                                                <input type="text" wire:model="parameters.da"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="00">
                                                @error('parameters.da')
                                                    <x-shared.validate-error :message="$message" />
                                                @enderror
                                            </div>
                                        </th>
                                        <th scope="row"
                                            class="px-2 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <div>
                                                <input type="text" wire:model="parameters.ue"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="00">
                                                @error('parameters.ue')
                                                    <x-shared.validate-error :message="$message" />
                                                @enderror
                                            </div>
                                        </th>
                                        <th scope="row"
                                            class="px-2 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <div>
                                                <input type="text" wire:model="parameters.categoria_prog"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="00">
                                                @error('parameters.categoria_prog')
                                                    <x-shared.validate-error :message="$message" />
                                                @enderror
                                            </div>
                                        </th>
                                        <th scope="row"
                                            class="px-2 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <div>
                                                <input type="text" wire:model="parameters.fuente"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="00">
                                                @error('parameters.fuente')
                                                    <x-shared.validate-error :message="$message" />
                                                @enderror
                                            </div>
                                        </th>
                                        <th scope="row"
                                            class="px-2 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <div>
                                                <input type="text" wire:model="parameters.org"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="00">
                                                @error('parameters.org')
                                                    <x-shared.validate-error :message="$message" />
                                                @enderror
                                            </div>
                                        </th>
                                        <th scope="row"
                                            class="px-2 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <div>
                                                <input type="text" wire:model="parameters.part"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="00">
                                                @error('parameters.part')
                                                    <x-shared.validate-error :message="$message" />
                                                @enderror
                                            </div>
                                        </th>
                                        <th scope="row"
                                            class="px-2 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <div>
                                                <input type="text" wire:model="parameters.descripcion"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="">
                                                @error('parameters.descripcion')
                                                    <x-shared.validate-error :message="$message" />
                                                @enderror
                                            </div>
                                        </th>
                                        <th scope="row"
                                            class="px-2 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <div>
                                                <input type="text" wire:model="parameters.importe"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    placeholder="00">
                                                @error('parameters.importe')
                                                    <x-shared.validate-error :message="$message" />
                                                @enderror
                                            </div>
                                        </th>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>


                </div>
            </section>
        </div>
    </x-shared.container>
</div>
