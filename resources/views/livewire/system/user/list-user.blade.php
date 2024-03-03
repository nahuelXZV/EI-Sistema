<div>
    <x-shared.breadcrumb :breadcrumbs="$breadcrumbs" />
    <section class="bg-gray-50 dark:bg-gray-900 mb-2 p-3 sm:p-5 rounded-b-lg">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-0">
            <div class="bg-white dark:bg-gray-800 relative sm:rounded-lg overflow-hidden">
                <div class="relative overflow-hidden bg-white  dark:bg-gray-800 sm:rounded-lg">
                    <div class="flex-row items-center justify-between p-4 space-y-3 sm:flex sm:space-y-0 sm:space-x-4">
                        <div>
                            <h5 class="mr-3 text-lg font-bold dark:text-white uppercase">usuarios</h5>
                        </div>
                        <a href="{{ route('user.new') }}"
                            class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                            <x-icons.new />
                            Nuevo
                        </a>
                    </div>
                </div>
                <div
                    class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/2">
                        <form class="flex items-center">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <x-icons.search />
                                </div>
                                <input type="text" id="simple-search"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Search" required="">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Nombre</th>
                                <th scope="col" class="px-4 py-3">Apellido</th>
                                <th scope="col" class="px-4 py-3">Correo</th>
                                <th scope="col" class="px-4 py-3">Cargo</th>
                                <th scope="col" class="px-4 py-3">Area</th>
                                <th scope="col" class="px-4 py-3">Rol</th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr
                                    class="border-b dark:border-gray-700 @if ($loop->even) bg-gray-100 dark:bg-gray-800 @endif">
                                    <th scope="row"
                                        class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $user->name }}
                                    </th>
                                    <td class="px-4 py-3">{{ '' }}</td>
                                    <td class="px-4 py-3">{{ $user->email }}</td>
                                    <td class="px-4 py-3">{{ '' }}</td>
                                    <td class="px-4 py-3">{{ '' }}</td>
                                    <td class="px-4 py-3 flex items-center justify-end">
                                        <a href="{{ route('user.edit', $user->id) }}"
                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-1.5  text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            <x-icons.edit />
                                        </a>
                                        <button type="button" wire:click="delete({{ $user->id }})"
                                            onclick="confirm('¿Está seguro?') || event.stopImmediatePropagation()"
                                            class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-1.5  text-center inline-flex items-center me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                            <x-icons.delete />
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
                    aria-label="Table navigation">
                    <X-shared.pagination :modelo=$users />
                </nav>
            </div>
        </div>
    </section>

</div>
