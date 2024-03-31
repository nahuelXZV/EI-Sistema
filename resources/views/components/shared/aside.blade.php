<div class="flex items-center justify-between px-4 py-1 sm:hidden">
    <button data-drawer-target="separator-sidebar" data-drawer-toggle="separator-sidebar" aria-controls="separator-sidebar"
        type="button"
        class="inline-flex items-center py-2 mt-2  text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
            </path>
        </svg>
    </button>

    <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
        class="inline-flex items-center py-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
        type="button">
        <x-icons.config />
    </button>
    <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
            <li>
                <a href="{{ route('profile.show') }}"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Perfil</a>
            </li>
            <li>
                <a onclick="toggleTheme()"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Cambiar
                    tema</a>
            </li>
            <li>
                <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <button type="submit" class="inline-flex justify-center">
                            Cerrar sesión
                        </button>
                    </form>
                </a>
            </li>

        </ul>
    </div>
</div>
<aside id="separator-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800 scroll-nice">
        <ul class="pt-2 mt-2 space-y-2 font-medium ">
            <a href="{{ route('dashboard') }}" class="flex items-center ps-2.5 mb-5">
                <img src="{{ asset('imgs/logo.jpg') }}" style="width:200px" style="margin-left:20px"
                    alt="Escuela ingenieria" id="logo">
            </a>
        </ul>
        <ul class="mt-2 space-y-1 font-medium">
            <li>
                <a href="{{ route('dashboard') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 group">
                    <x-icons.home />
                    <span class="ms-3">Inicio</span>
                </a>
            </li>
            <li>
                <button type="button"
                    class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-200 dark:text-white dark:hover:bg-gray-700"
                    aria-controls="dropdown-usuario" data-collapse-toggle="dropdown-usuario">
                    <x-icons.users />
                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Usuarios</span>
                    <x-icons.chevron-down />
                </button>
                <ul id="dropdown-usuario" class="hidden py-2 space-y-2">
                    <li>
                        <a href="{{ route('user.list') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-200 dark:text-white dark:hover:bg-gray-700">Usuarios</a>
                    </li>
                    <li>
                        <a href="{{ route('role.list') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-200 dark:text-white dark:hover:bg-gray-700">Roles</a>
                    </li>
                    <li>
                        <a href="{{ route('area.list') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-200 dark:text-white dark:hover:bg-gray-700">Area</a>
                    </li>
                    <li>
                        <a href="{{ route('position.list') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-200 dark:text-white dark:hover:bg-gray-700">Cargo</a>
                    </li>
                </ul>
            </li>
            <li>
                <button type="button"
                    class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-200 dark:text-white dark:hover:bg-gray-700"
                    aria-controls="dropdown-academico" data-collapse-toggle="dropdown-academico">
                    <x-icons.book />
                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Academico</span>
                    <x-icons.chevron-down />
                </button>
                <ul id="dropdown-academico" class="hidden py-2 space-y-2">
                    <li>
                        <a href="{{ route('student.list') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-200 dark:text-white dark:hover:bg-gray-700">Estudiantes</a>
                    </li>
                    <li>
                        <a href="{{ route('program.list') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-200 dark:text-white dark:hover:bg-gray-700">Programas</a>
                    </li>
                    <li>
                        <a href="{{ route('course.list') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-200 dark:text-white dark:hover:bg-gray-700">Cursos</a>
                    </li>
                    <li>
                        <a href="{{ route('teacher.list') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-200 dark:text-white dark:hover:bg-gray-700">Docentes</a>
                    </li>
                    <li>
                        <a href="{{ route('university.list') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-200 dark:text-white dark:hover:bg-gray-700">Universidades</a>
                    </li>
                    <li>
                        <a href="{{ route('career.list') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-200 dark:text-white dark:hover:bg-gray-700">Carreras</a>
                    </li>
                    <li>
                        <a href="{{ route('process.list') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-200 dark:text-white dark:hover:bg-gray-700">Procesos</a>
                    </li>
                    <li>
                        <a href="{{ route('requirement.list') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-200 dark:text-white dark:hover:bg-gray-700">Requisitos</a>
                    </li>
                    <li>
                        <a href="{{ route('area-profession.list') }}"
                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-200 dark:text-white dark:hover:bg-gray-700">Area de profession</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <div
        class="hidden absolute bottom-0 left-0 justify-center p-4 space-x-4 w-full lg:flex bg-gray-50 dark:bg-gray-800 z-20 border-r border-gray-200 dark:border-gray-700">
        <a href="{{ route('profile.show') }}"
            class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-600">
            <x-icons.profile />
        </a>
        <button href="#" onclick="toggleTheme()"
            class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-600">
            <x-icons.sun />
        </button>
        <form method="POST" action="{{ route('logout') }}" x-data>
            @csrf
            <button type="submit"
                class="inline-flex justify-center p-2 text-gray-500 rounded
                cursor-pointer dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100
                dark:hover:bg-gray-600">
                <x-icons.logout />
            </button>
        </form>
    </div>
</aside>

<script>
    function toggleTheme() {
        const html = document.querySelector('html');
        if (html.classList.contains('dark')) {
            html.classList.remove('dark');
            localStorage.setItem('dark', 'false');
            document.getElementById('logo').src = "{{ asset('imgs/logo.jpg') }}";
        } else {
            html.classList.add('dark');
            localStorage.setItem('dark', 'true');
            document.getElementById('logo').src = "{{ asset('imgs/logo-black.png') }}";
        }
    }
</script>
