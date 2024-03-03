<?php

namespace App\Livewire\System\Role;

use App\Services\System\RoleService;
use Livewire\Component;
use Livewire\WithPagination;

class ListRole extends Component
{
    use WithPagination;
    protected $listeners = ['cleanerNotificacion'];

    public $breadcrumbs = [['title' => "Roles", "url" => "role.list"]];
    public $search = '';
    public $notificacion = false;
    public $type = '';
    public $message = '';


    public function mount()
    {
    }

    public function cleanerNotificacion()
    {
        $this->notificacion = null;
        $this->search = '';
        $this->type = '';
    }

    public function updatingAttribute()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        if (RoleService::delete($id)) {
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
        $roles = RoleService::getAllPaginate($this->search, 15);
        return view('livewire.system.role.list-role', compact('roles'));
    }
}
