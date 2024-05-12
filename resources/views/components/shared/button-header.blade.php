@props(['title', 'route', 'params' => [], 'type' => 'a', 'clickAction'])
@if ($type == 'button')
    <button @if ($clickAction) wire:click="{{ $clickAction }}" @endif
        class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-fondo hover:bg-primary-900 focus:ring-4 focus:ring-primary-300 dark:bg-fondo dark:hover:bg-primary-900 focus:outline-none dark:focus:ring-primary-900">
        {{ $title }}
    </button>
@endif
@if ($type == 'a')
    <a href="{{ route($route, $params) }}"
        class=" flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-fondo hover:bg-primary-900 focus:ring-4 focus:ring-primary-300 dark:bg-fondo dark:hover:bg-primary-900 focus:outline-none dark:focus:ring-primary-900">
        {{ $title }}
    </a>
@endif
@if ($type == 'download')
    <a href="{{ asset($route) }}" target="_blank"
        class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-fondo hover:bg-primary-900 focus:ring-4 focus:ring-primary-300 dark:bg-fondo dark:hover:bg-primary-900 focus:outline-none dark:focus:ring-primary-900">
        {{ $title }}
    </a>
@endif
@if ($type == 'downloadParams')
    <a href="{{ route($route, $params) }}" target="_blank"
        class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-fondo hover:bg-primary-900 focus:ring-4 focus:ring-primary-300 dark:bg-fondo dark:hover:bg-primary-900 focus:outline-none dark:focus:ring-primary-900">
        {{ $title }}
    </a>
@endif
