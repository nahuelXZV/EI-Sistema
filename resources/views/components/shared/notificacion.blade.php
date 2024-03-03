@props(['message', 'type' => 'success'])

@if ($type === 'success')
    <div
        class="fixed flex items-center w-full max-w-xs p-4 space-x-4 text-white bg-green-400 rounded-lg shadow-lg top-24 right-7 dark:text-white space-x dark:bg-green-600">
        <x-icons.alert />
        <div class="ml-3 text-md font-bold w-full">{{ $message }}.</div>
    </div>
@endif

@if ($type === 'error')
    <div
        class="fixed flex items-center w-full max-w-xs p-4 space-x-4 text-white bg-red-600 rounded-lg shadow-lg top-24 right-7 dark:text-white space-x dark:bg-red-800">
        <x-icons.error />
        <div class="ml-3 text-md font-bold w-full">{{ $message }}.</div>
    </div>
@endif
