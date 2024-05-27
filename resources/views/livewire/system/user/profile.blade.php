<div>
    <x-form-section submit="updateProfile" class="mb-4">
        <x-slot name="title">
            {{ __('Información del perfil') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Actualice la información del perfil y la dirección de correo electrónico de su cuenta.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <x-label for="nombre" value="{{ __('Nombre') }}" />
                <x-input id="nombre" type="text" class="mt-1 block w-full" wire:model="nombre" required
                    autocomplete="nombre" />
                <x-input-error for="nombre" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="apellido" value="{{ __('Apellido') }}" />
                <x-input id="apellido" type="text" class="mt-1 block w-full" wire:model="apellido" required
                    autocomplete="apellido" />
                <x-input-error for="apellido" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-label for="email" value="{{ __('Correo') }}" />
                <x-input id="email" type="email" class="mt-1 block w-full" wire:model="email" required
                    autocomplete="username" />
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
    <x-form-section submit="updatePassword" class="mb-4">
        <x-slot name="title">
            {{ __('Actualizar contraseña') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Asegúrese de que su cuenta utilice una contraseña larga y aleatoria para mantenerse segura.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <x-label for="current_password" value="{{ __('Contraseña actual') }}" />
                <x-input id="current_password" type="password" class="mt-1 block w-full"
                    wire:model="current_password" autocomplete="current-password" />
                <x-input-error for="current_password" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-label for="password" value="{{ __('Nueva contraseña') }}" />
                <x-input id="password" type="password" class="mt-1 block w-full" wire:model="password"
                    autocomplete="new-password" />
                <x-input-error for="password" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-label for="password_confirmation" value="{{ __('Confirmar Contraseña') }}" />
                <x-input id="password_confirmation" type="password" class="mt-1 block w-full"
                    wire:model="password_confirmation" autocomplete="new-password" />
                <x-input-error for="password_confirmation" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-action-message class="me-3" on="saved">
                {{ __('Guardado.') }}
            </x-action-message>

            <x-button>
                {{ __('Guardar') }}
            </x-button>
        </x-slot>
    </x-form-section>
    @if ($notificacion)
        <x-shared.notificacion :message="$message" :type="$type" />
        @script
            <script>
                setTimeout(() => {
                    $wire.dispatch('cleanerNotificacion');
                }, 3500);
            </script>
        @endscript
    @endif
</div>
