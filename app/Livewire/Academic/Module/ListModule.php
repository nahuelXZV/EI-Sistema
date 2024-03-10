<?php

namespace App\Livewire\Academic\Module;

use App\Services\Academic\ModuleService;
use Livewire\Component;
use Livewire\WithPagination;

class ListModule extends Component
{
    use WithPagination;
    protected $listeners = ['cleanerNotificacion'];

    public $breadcrumbs = [['title' => "Modulos", "url" => "module.list"]];
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
        if (ModuleService::delete($id)) {
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
        $modules = ModuleService::getAllPaginate($this->search, 15);
        return view('livewire.academic.module.list-module', compact('modules'));
    }
}
