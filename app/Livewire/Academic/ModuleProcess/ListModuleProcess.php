<?php

namespace App\Livewire\Academic\ModuleProcess;

use App\Services\Academic\ModuleProcessService;
use Livewire\Component;
use Livewire\WithPagination;

class ListModuleProcess extends Component
{
    use WithPagination;
    protected $listeners = ['cleanerNotificacion'];

    public $breadcrumbs = [['title' => "Procesos", "url" => "process.list"]];
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
        if (ModuleProcessService::delete($id)) {
            $this->message = 'Eliminado correctamente';
            $this->type = 'success';
        } else {
            $this->message = 'Error al eliminar';
            $this->type = 'error';
        }
        $this->notificacion = true;
    }

    public function level_up($id)
    {
        if (ModuleProcessService::level_up($id)) {
            $this->render();
        }
    }

    public function level_down($id)
    {
        if (ModuleProcessService::level_down($id)) {
            $this->render();
        }
    }

    public function render()
    {
        $processes = ModuleProcessService::getAllPaginate($this->search, 15);
        return view('livewire.academic.module-process.list-module-process',compact('processes'));
    }
}
