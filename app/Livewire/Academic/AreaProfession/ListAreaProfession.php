<?php

namespace App\Livewire\Academic\AreaProfession;

use App\Services\Academic\AreaProfessionService;
use Livewire\Component;
use Livewire\WithPagination;

class ListAreaProfession extends Component
{
    use WithPagination;
    protected $listeners = ['cleanerNotificacion'];

    public $breadcrumbs = [['title' => "Areas de profession", "url" => "area-profession.list"]];
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
        if (AreaProfessionService::delete($id)) {
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
        $areas = AreaProfessionService::getAllPaginate($this->search, 15);
        return view('livewire.academic.area-profession.list-area-profession', compact('areas'));
    }
}
