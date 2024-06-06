@props([
    'icon',
    'text',
    'route',
    'color',
    'type',
    'params',
    'tonality' => '700',
    'hover' => '800',
    'action',
    'text',
    'target' => false,
])
@if ($type === 'a')
    <a href="{{ route($route, $params) }}" @if ($target) target="_blank" @endif
        class="text-white bg-{{ $color }}-{{ $tonality }} hover:bg-{{ $color }}-{{ $hover }} focus:ring-4 focus:outline-none focus:ring-{{ $color }}-300 font-medium rounded-lg text-sm p-1.5 px-2 text-center inline-flex items-center me-1 dark:bg-{{ $color }}-600 dark:hover:bg-{{ $color }}-{{ $tonality }} dark:focus:ring-{{ $color }}-{{ $hover }}">
        @if ($icon === 'edit')
            <x-icons.edit />
        @endif
        @if ($icon === 'delete')
            <x-icons.delete />
        @endif
        @if ($icon === 'show')
            <x-icons.show />
        @endif
        @if ($icon === 'pdf')
            <x-icons.pdf />
        @endif
        @if ($icon === 'excel')
            <x-icons.excel />
        @endif
        <span class="mx-2">
            {{ $text }}
        </span>
    </a>
@endif
@if ($type === 'button')
    <button type="button" wire:click="{{ $action }}({{ $params }})" wire:loading.attr="disabled"
        class="text-white bg-{{ $color }}-{{ $tonality }} hover:bg-{{ $color }}-{{ $hover }} focus:ring-4 focus:outline-none focus:ring-{{ $color }}-300 font-medium rounded-lg text-sm p-1.5 px-2 text-center inline-flex items-center me-1 dark:bg-{{ $color }}-600 dark:hover:bg-{{ $color }}-{{ $tonality }} dark:focus:ring-{{ $color }}-{{ $hover }}">
        @if ($icon === 'edit')
            <x-icons.edit />
        @endif
        @if ($icon === 'delete')
            <x-icons.delete />
        @endif
        @if ($icon === 'show')
            <x-icons.show />
        @endif
        @if ($icon === 'done')
            <x-icons.done />
        @endif
        @if ($icon === 'arrow-up')
            <x-icons.arrow-up />
        @endif
        @if ($icon === 'arrow-down')
            <x-icons.arrow-down />
        @endif
        @if ($icon === 'arrow-path')
            <x-icons.arrow-path />
        @endif
        @if ($icon === 'exclamation')
            <x-icons.exclamation />
        @endif
        @if ($icon === 'pdf')
            <x-icons.pdf />
        @endif
        @if ($icon === 'excel')
            <x-icons.excel />
        @endif
        <span class="mx-2">
            {{ $text }}
        </span>
    </button>
@endif
@if ($type === 'asset')
    <a href="{{ asset($params) }}" target="_blank"
        class="text-white bg-{{ $color }}-{{ $tonality }} hover:bg-{{ $color }}-{{ $hover }} focus:ring-4 focus:outline-none focus:ring-{{ $color }}-300 font-medium rounded-lg text-sm p-1.5  text-center inline-flex items-center me-1 dark:bg-{{ $color }}-600 dark:hover:bg-{{ $color }}-{{ $tonality }} dark:focus:ring-{{ $color }}-{{ $hover }}">
        @if ($icon === 'show')
            <x-icons.show />
        @endif

        <span class="mx-2">
            {{ $text }}
        </span>
    </a>
@endif
