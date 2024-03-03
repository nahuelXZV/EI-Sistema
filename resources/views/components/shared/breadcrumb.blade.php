@props(['breadcrumbs'])

<nav class="mx-auto flex px-5 py-3 text-gray-700 rounded-t-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
        <li class="inline-flex items-center">
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <x-icons.home-bread />
                Inicio
            </a>
        </li>
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($loop->last)
                <li aria-current="page">
                    <div class="flex items-center">
                        <x-icons.arrow-right />
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">
                            {{ $breadcrumb['title'] }}</span>
                    </div>
                </li>
            @else
                <li>
                    <div class="flex items-center">
                        <x-icons.arrow-right />
                        <a href="{{ route($breadcrumb['url']) }}"
                            class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">{{ $breadcrumb['title'] }}</a>
                        </a>
                    </div>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
