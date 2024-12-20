<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Información del perfil') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Actualice la información del perfil y la dirección de correo electrónico de su cuenta.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="nombre" value="{{ __('Nombre') }}" />
            <x-input id="nombre" type="text" class="mt-1 block w-full" wire:model="state.nombre" required autocomplete="nombre" />
            <x-input-error for="nombre" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-label for="apellido" value="{{ __('Apellido') }}" />
            <x-input id="apellido" type="text" class="mt-1 block w-full" wire:model="state.apellido" required autocomplete="apellido" />
            <x-input-error for="apellido" class="mt-2" />
        </div>
        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Correo') }}" />
            <x-input id="email" type="email" class="mt-1 block w-full" wire:model="state.email" required autocomplete="username" />
            <x-input-error for="email" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Guardado.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Guardar') }}
        </x-button>
    </x-slot>
</x-form-section>
