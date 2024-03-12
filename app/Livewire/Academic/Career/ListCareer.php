<?php

namespace App\Livewire\Academic\Career;

use App\Services\Academic\CareerService;
use Livewire\Component;
use Livewire\WithPagination;

class ListCareer extends Component
{
    use WithPagination;
    protected $listeners = ['cleanerNotificacion'];

    public $breadcrumbs = [['title' => "Carreras", "url" => "career.list"]];
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
        if (CareerService::delete($id)) {
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
        $careers = CareerService::getAllPaginate($this->search, 15);
        return view('livewire.academic.career.list-career',compact('careers'));
    }
}
