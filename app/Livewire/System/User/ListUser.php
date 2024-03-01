<?php

namespace App\Livewire\System\User;

use App\Services\System\UserService;
use Livewire\Component;
use Livewire\WithPagination;

class ListUser extends Component
{
    use WithPagination;
    public $breadcrumbs = [['title' => "Usuarios", "url" => "user.list"]];
    public $search = '';
    public $notificacion = false;
    public $type = 'success';
    public $message = 'Creado correctamente';


    public function mount()
    {
    }

    public function toggleNotificacion()
    {
        $this->notificacion = !$this->notificacion;
        $this->emit('notificacion');
    }

    public function updatingAttribute()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        if (UserService::delete($id)) {
            $this->message = 'Eliminado correctamente';
            $this->type = 'success';
        } else {
            $this->message = 'Error al eliminar';
            $this->type = 'error';
        }
        $this->notificacion = true;
    }

    public function render()
    {
        $users = UserService::getAll($this->search, 20);
        return view('livewire.system.user.list-user', compact('users'));
    }
}
