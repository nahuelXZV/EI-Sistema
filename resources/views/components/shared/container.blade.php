@props(['breadcrumbs'])
<x-shared.breadcrumb :breadcrumbs="$breadcrumbs" />
<section class="bg-gray-50 dark:bg-gray-900 mb-2 py-3 sm:p-5 rounded-b-lg">
    <div class="mx-auto max-w-screen-xl px-4 lg:px-0">
        <div class="bg-white dark:bg-gray-800 relative sm:rounded-lg overflow-hidden">
            {{ $slot }}
        </div>
    </div>
</section>
