@props(['modelo'])
@if ($modelo->hasPages())
    <div class="d-flex flex-row mt-1 text-black dark:text-white">
        {{ $modelo->links() }}
    </div>
@endif
