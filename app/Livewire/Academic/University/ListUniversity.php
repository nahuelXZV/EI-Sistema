<?php

namespace App\Livewire\Academic\University;

use App\Services\Academic\UniversityService;
use Livewire\Component;
use Livewire\WithPagination;

class ListUniversity extends Component
{
    use WithPagination;
    protected $listeners = ['cleanerNotificacion'];

    public $breadcrumbs = [['title' => "Universidades", "url" => "university.list"]];
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
        if (UniversityService::delete($id)) {
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
        $universities = UniversityService::getAllPaginate($this->search, 15);
        return view('livewire.academic.university.list-university',compact('universities'));
    }
}
