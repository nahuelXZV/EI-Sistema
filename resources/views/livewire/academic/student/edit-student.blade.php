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
                    <div class="col-span-3 sm:col-span-1">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Honorifico
                        </label>
                        <select wire:model.blur="studentArray.honorifico"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected="" value="">Seleccione un honorifico</option>
                            @foreach ($honorifics as $honorific)
                                <option value="{{ $honorific }}">{{ $honorific }}</option>
                            @endforeach
                        </select>
                        @error('studentArray.honorifico')
                            <x-shared.validate-error :message="$message" />
                        @enderror
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre
                        </label>
                        <input type="text" wire:model.blur="studentArray.nombre"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Nombre" required="">
                        @error('studentArray.nombre')
                            <x-shared.validate-error :message="$message" />
                        @enderror
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Apellido
                        </label>
                        <input type="text" wire:model.blur="studentArray.apellido"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Apellido" required="">
                        @error('studentArray.apellido')
                            <x-shared.validate-error :message="$message" />
                        @enderror
                    </div>

                    <div class="col-span-3 sm:col-span-1">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nacionalidad</label>
                        <input type="text" wire:model.blur="studentArray.nacionalidad"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Boliviano" required="">
                        @error('studentArray.nacionalidad')
                            <x-shared.validate-error :message="$message" />
                        @enderror
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <label for="rol"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cedula</label>
                        <input type="text" wire:model.blur="studentArray.cedula"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Cedula" required="">
                        @error('studentArray.cedula')
                            <x-shared.validate-error :message="$message" />
                        @enderror
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Expedicion</label>
                        <select wire:model.blur="studentArray.expedicion"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected="" value="">Seleccione una expedicion</option>
                            @foreach ($expeditions as $expedition)
                                <option value="{{ $expedition }}">{{ $expedition }}</option>
                            @endforeach
                        </select>
                        @error('studentArray.expedicion')
                            <x-shared.validate-error :message="$message" />
                        @enderror
                    </div>




                    {{-- carrera, universidad --}}
                    <div class="col-span-3 sm:col-span-1">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Universidad</label>
                        <select wire:model.blur="studentArray.universidad_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected="" value="">Seleccione una universidad</option>
                            @foreach ($universities as $university)
                                <option value="{{ $university->id }}">{{ $university->nombre }}</option>
                            @endforeach
                        </select>
                        @error('studentArray.universidad_id')
                            <x-shared.validate-error :message="$message" />
                        @enderror
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Carrera</label>
                        <select wire:model.blur="studentArray.carrera_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected="" value="">Seleccione una carrera</option>
                            @foreach ($careers as $career)
                                <option value="{{ $career->id }}">{{ $career->nombre }}</option>
                            @endforeach
                        </select>
                        @error('studentArray.carrera_id')
                            <x-shared.validate-error :message="$message" />
                        @enderror
                    </div>

                    <div class="col-span-3 sm:col-span-1">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nro de
                            registro</label>
                        <input type="text" wire:model.blur="studentArray.nro_registro"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="219060185" required="">
                        @error('studentArray.nro_registro')
                            <x-shared.validate-error :message="$message" />
                        @enderror
                    </div>

                    <div class="col-span-3 sm:col-span-1">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sexo</label>
                        <select wire:model.blur="studentArray.sexo"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg  block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected="" value="">Seleccione el sexo</option>
                            <option value="masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                        @error('studentArray.sexo')
                            <x-shared.validate-error :message="$message" />
                        @enderror
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Correo
                        </label>
                        <input type="email" wire:model.blur="studentArray.correo"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Correo" required="">
                        @error('studentArray.correo')
                            <x-shared.validate-error :message="$message" />
                        @enderror
                    </div>

                    <div class="col-span-3 sm:col-span-1">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Telefono
                        </label>
                        <input type="number" wire:model.blur="studentArray.telefono"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Telefono" required="">
                        @error('studentArray.telefono')
                            <x-shared.validate-error :message="$message" />
                        @enderror
                    </div>

                    <div class="col-span-3 sm:col-span-1">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Subir Foto
                        </label>
                        <input type="file" wire:model.blur="foto" accept="image/*"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        @error('foto')
                            <x-shared.validate-error :message="$message" />
                        @enderror
                    </div>
                    <x-shared.space />
                    <x-shared.space />
                </div>
            </section>
        </div>
    </x-shared.container>
</div>
