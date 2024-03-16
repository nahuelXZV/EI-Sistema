@props(['icon', 'text', 'route', 'color', 'type', 'params', 'tonality' => '700', 'hover' => '800'])
@if ($type === 'a')
    <a href="{{ route($route, $params) }}"
        class="text-white bg-{{ $color }}-{{ $tonality }} hover:bg-{{ $color }}-{{ $hover }} focus:ring-4 focus:outline-none focus:ring-{{ $color }}-300 font-medium rounded-lg text-sm p-1.5  text-center inline-flex items-center me-1 dark:bg-{{ $color }}-600 dark:hover:bg-{{ $color }}-{{ $tonality }} dark:focus:ring-{{ $color }}-{{ $hover }}">
        @if ($icon === 'edit')
            <x-icons.edit />
        @endif
        @if ($icon === 'delete')
            <x-icons.delete />
        @endif
        @if ($icon === 'show')
            <x-icons.show />
        @endif
    </a>
@endif
@if ($type === 'button')
    <button type="button" onclick="confirm('¿Está seguro?') || event.stopImmediatePropagation()"
        wire:click="delete({{ $params }})"
        class="text-white bg-{{ $color }}-{{ $tonality }} hover:bg-{{ $color }}-{{ $hover }} focus:ring-4 focus:outline-none focus:ring-{{ $color }}-300 font-medium rounded-lg text-sm p-1.5  text-center inline-flex items-center me-1 dark:bg-{{ $color }}-600 dark:hover:bg-{{ $color }}-{{ $tonality }} dark:focus:ring-{{ $color }}-{{ $hover }}">
        @if ($icon === 'edit')
            <x-icons.edit />
        @endif
        @if ($icon === 'delete')
            <x-icons.delete />
        @endif
        @if ($icon === 'show')
            <x-icons.show />
        @endif
    </button>
@endif
@if ($type === 'arrow-up' || $type === 'arrow-down')
    @php
        $action = $type === 'arrow-up' ? 'level_up' : 'level_down';
    @endphp
    <button type="button" wire:click="{{ $action }}({{ $params }})"
        class="text-white bg-{{ $color }}-{{ $tonality }} hover:bg-{{ $color }}-{{ $hover }} focus:ring-4 focus:outline-none focus:ring-{{ $color }}-300 font-medium rounded-lg text-sm p-1.5 text-center inline-flex items-center me-1 dark:bg-{{ $color }}-600 dark:hover:bg-{{ $color }}-{{ $tonality }} dark:focus:ring-{{ $color }}-{{ $hover }}">
        @if ($type === 'arrow-up')
            <x-icons.arrow-up />
        @endif
        @if ($type === 'arrow-down')
            <x-icons.arrow-down />
        @endif
    </button>
@endif

