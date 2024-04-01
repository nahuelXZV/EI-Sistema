<div>
    <x-shared.container :breadcrumbs="$breadcrumbs">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 p-4 gap-4">
            <div
                class="bg-gray-100 dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-fondo dark:border-white text-fondo dark:text-white font-medium group">
                <div
                    class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                    <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 0 24 24" width="30px" fill="#b91c1c">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM9 4h2v5l-1-.75L9 9V4zm9 16H6V4h1v9l3-2.25L13 13V4h5v16z" />
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl">{{ $courses }}</p>
                    <p>Cursos Activos</p>
                </div>
            </div>
            <div
                class="bg-gray-100 dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-fondo dark:border-white text-fondo dark:text-white font-medium group">
                <div
                    class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                    <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="stroke-current text-red-700 transform transition-transform duration-500 ease-in-out">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl">{{ $students }}</p>
                    <p>Estudiantes Activos</p>
                </div>
            </div>
            <div
                class="bg-gray-100 dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-fondo dark:border-white text-fondo dark:text-white font-medium group">
                <div
                    class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                    <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 0 24 24" width="30px"
                        fill="#b91c1c">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM9 4h2v5l-1-.75L9 9V4zm9 16H6V4h1v9l3-2.25L13 13V4h5v16z" />
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl">{{ $programs }}</p>
                    <p>Programas Activos</p>
                </div>
            </div>
            <div
                class="bg-gray-100 dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-fondo dark:border-white text-fondo dark:text-white font-medium group">
                <div
                    class="flex justify-center items-center w-14 h-14 bg-white rounded-full transition-all duration-300 transform group-hover:rotate-12">
                    <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="stroke-current text-red-700 transform transition-transform duration-500 ease-in-out">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
                <div class="text-right">
                    <p class="text-2xl">{{ $users }}</p>
                    <p>Usuarios</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2">

            {{-- BarChart --}}
            <div class="px-4">
                <div class="max-w-lg mx-auto py-10">
                    <div class="shadow p-6 rounded-lg bg-gray-100">
                        <div class="md:flex md:justify-between md:items-center">
                            <div>
                                <h2 class="text-xl text-gray-800 font-bold leading-tight">Estudiantes</h2>
                                <p class="mb-2 text-gray-600 text-sm">Estados del estudiante</p>
                            </div>

                            <!-- Legends -->
                            <div class="mb-4">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-fondo mr-2 rounded-full"></div>
                                    <div class="text-sm text-gray-700">Cantidad</div>
                                </div>
                            </div>
                        </div>


                        <div class="my-8 relative"
                            style="background: repeating-linear-gradient(to bottom, #eee, #eee 1px, #fff 1px, #fff 10%) ">
                            <!-- Bar Chart -->
                            <div class="flex -mx-2 items-end">
                                @foreach ($cantStateStudents as $data)
                                    <div class="px-2 w-1/4">
                                        <div style="height: {{ $data }}px"
                                            class="transition ease-in duration-200 bg-fondo hover:bg-red-700 relative">
                                            <div
                                                class="text-center absolute top-0 left-0 right-0 -mt-6 text-gray-800 text-sm">
                                                {{ $data }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Labels -->
                            <div class="border-t border-gray-400 mx-auto"
                                style="height: 1px; width: {{ 100 - (1 / count($cantStateStudents)) * 100 + 3 }}%">
                            </div>
                            <div class="flex -mx-2 items-end">
                                @foreach ($stateStudents as $label)
                                    <div class="px-2 w-1/4">
                                        <div class="bg-red-600 relative">
                                            <div class="text-center absolute top-0 left-0 right-0 h-2 -mt-px bg-gray-400 mx-auto"
                                                style="width: 1px"></div>
                                            <div
                                                class="text-center absolute top-0 left-0 right-0 mt-3 text-gray-700 text-sm">
                                                {{ $label }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- BarChart --}}
            <div class="px-4">
                <div class="max-w-lg mx-auto py-10">
                    <div class="shadow p-6 rounded-lg bg-gray-100">
                        <div class="md:flex md:justify-between md:items-center">
                            <div>
                                <h2 class="text-xl text-gray-800 font-bold leading-tight">Programas</h2>
                                <p class="mb-2 text-gray-600 text-sm">Tipos de programas</p>
                            </div>

                            <!-- Legends -->
                            <div class="mb-4">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-fondo mr-2 rounded-full"></div>
                                    <div class="text-sm text-gray-700">Cantidad</div>
                                </div>
                            </div>
                        </div>


                        <div class="my-8 relative"
                            style="background: repeating-linear-gradient(to bottom, #eee, #eee 1px, #fff 1px, #fff 10%) ">
                            <!-- Bar Chart -->
                            <div class="flex -mx-2 items-end">
                                @foreach ($cantProgramTypes as $data)
                                    <div class="px-2 w-1/4">
                                        <div style="height: {{ $data }}px"
                                            class="transition ease-in duration-200 bg-fondo hover:bg-red-700 relative">
                                            <div
                                                class="text-center absolute top-0 left-0 right-0 -mt-6 text-gray-800 text-sm">
                                                {{ $data }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Labels -->
                            <div class="border-t border-gray-400 mx-auto"
                                style="height: 1px; width: {{ 100 - (1 / count($cantProgramTypes)) * 100 + 3 }}%">
                            </div>
                            <div class="flex -mx-2 items-end">
                                @foreach ($programTypes as $label)
                                    <div class="px-2 w-1/4">
                                        <div class="bg-red-600 relative">
                                            <div class="text-center absolute top-0 left-0 right-0 h-2 -mt-px bg-gray-400 mx-auto"
                                                style="width: 1px"></div>
                                            <div
                                                class="text-center absolute top-0 left-0 right-0 mt-3 text-gray-700 text-sm">
                                                {{ $label }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2">

            {{-- Table Users --}}
            <div class="p-4">
                <div class=" max-w-lg mx-auto bg-gray-100 shadow rounded-lg">
                    <div class="flex flex-wrap items-center px-4 py-2 bg-gray-100 shadow-lg rounded">
                        <div class="relative w-full max-w-full flex-grow flex-1">
                            <h3 class="text-xl text-gray-800 font-bold leading-tight">Usuarios</h3>
                        </div>
                    </div>
                    <div class="block w-full overflow-x-auto">
                        <table class="items-center w-full bg-transparent border-collapse">
                            <thead>
                                <tr>
                                    <th
                                        class="px-4 bg-white dark:bg-gray-600 text-gray-500 dark:text-gray-100 align-middle border border-solid border-gray-200 dark:border-gray-500 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                        Rol</th>
                                    <th
                                        class="px-4 bg-white dark:bg-gray-600 text-gray-500 dark:text-gray-100 align-middle border border-solid border-gray-200 dark:border-gray-500 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                        Cantidad</th>
                                    <th
                                        class="px-4 bg-white dark:bg-gray-600 text-gray-500 dark:text-gray-100 align-middle border border-solid border-gray-200 dark:border-gray-500 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left min-w-140-px">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cantUsersbyRole as $rol)
                                    <tr class="text-gray-700">
                                        <th
                                            class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                            {{ $rol['rol'] }}</th>
                                        <td
                                            class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                            {{ $rol['cantidad_usuarios'] }}</td>
                                        <td
                                            class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                            <div class="flex items-center">
                                                <span class="mr-2">{{ $rol['porcentaje_usuarios'] }}%</span>
                                                <div class="relative w-full">
                                                    <div
                                                        class="overflow-hidden h-2 text-xs flex rounded bg-gray-200 shadow-sm">
                                                        <div style="width: {{ $rol['porcentaje_usuarios'] }}%"
                                                            class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-fondo">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>



    </x-shared.container>
</div>
