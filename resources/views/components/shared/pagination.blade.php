@props(['model'])
@if ($model->hasPages())
    <div class="d-flex flex-row mt-1 text-black dark:text-white">
        {{ $model->links() }}
    </div>
@endif
