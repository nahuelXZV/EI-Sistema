@props(['color', 'slot'])
<span
    class="px-2 py-1 font-semibold leading-tight text-white bg-{{ $color }}-400 rounded-full dark:bg-{{ $color }}-500 dark:text-{{ $color }}-300">
    {{ $slot }}

</span>
