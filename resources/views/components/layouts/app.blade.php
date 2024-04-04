<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/jpg" href="{{ asset('imgs/logo1.jpg') }}">
    <title>EI-SISTEMA</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />

    <style>
        .scroll-nice {
            height: 200px;
            overflow-y: auto;
        }

        .scroll-nice::-webkit-scrollbar {
            width: 5px;
        }

        .scroll-nice::-webkit-scrollbar-thumb {
            background-color: #aaa7a7;
            border-radius: 4px;
        }

        .scroll-nice::-webkit-scrollbar-track {
            background-color: #f7eded;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    @livewireStyles
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-700">
        <x-shared.aside />

        <div class="p-4 pt-5 sm:ml-64 bg-gray-100 dark:bg-gray-700">
            {{ $slot }}
        </div>
    </div>
    @stack('modals')
    @stack('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    @livewireScripts
    <script>
        const html = document.querySelector('html');
        const theme = localStorage.getItem('dark');
        if (theme === 'true') {
            html.classList.add('dark');
            document.getElementById('logo').src = "{{ asset('imgs/logo-black.png') }}";
        } else {
            html.classList.remove('dark');
            document.getElementById('logo').src = "{{ asset('imgs/logo.jpg') }}";
        }
    </script>
</body>

</html>
