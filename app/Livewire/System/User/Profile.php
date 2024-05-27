<?php

namespace App\Livewire\System\User;

use Livewire\Component;

class Profile extends Component
{
    public $user;
    public $nombre;
    public $apellido;
    public $email;
    public $current_password;
    public $password;
    public $password_confirmation;

    public $notificacion = false;
    public $type = '';
    public $message = '';

    public function mount()
    {
        $this->user = auth()->user();
        $this->nombre = $this->user->nombre;
        $this->apellido = $this->user->apellido;
        $this->email = $this->user->email;
    }

    public function updateProfile()
    {
        $this->validate([
            'nombre' => 'required|string|max:191',
            'apellido' => 'required|string|max:191',
            'email' => 'required|email|max:191|unique:users,email,' . $this->user->id,
        ]);

        $this->user->update([
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'email' => $this->email,
        ]);
        $this->notificacion = true;
        $this->type = 'success';
        $this->message = 'Perfil actualizado correctamente';
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required|string|min:8',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string',
        ]);

        if (!password_verify($this->current_password, $this->user->password)) {
            $this->notificacion = true;
            $this->type = 'error';
            $this->message = 'La contraseña actual no coincide';
            return;
        }

        if ($this->password !== $this->password_confirmation) {
            $this->notificacion = true;
            $this->type = 'error';
            $this->message = 'Las contraseñas no coinciden';
            return;
        }

        $this->user->update([
            'password' => bcrypt($this->password),
        ]);
        $this->notificacion = true;
        $this->type = 'success';
        $this->message = 'Contraseña actualizada correctamente';
    }

    public function cleanerNotificacion()
    {
        $this->notificacion = null;
        $this->type = '';
        $this->message = '';
    }


    public function render()
    {
        return view('livewire.system.user.profile');
    }
}
