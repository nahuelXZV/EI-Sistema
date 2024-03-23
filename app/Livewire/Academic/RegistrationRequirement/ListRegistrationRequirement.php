<?php

namespace App\Livewire\Academic\RegistrationRequirement;

use App\Services\Academic\RegistrationRequirementService;
use Livewire\Component;
use Livewire\WithPagination;

class ListRegistrationRequirement extends Component
{
    use WithPagination;
    protected $listeners = ['cleanerNotificacion'];

    public $breadcrumbs = [['title' => "Requisitos", "url" => "requirement.list"]];
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
        if (RegistrationRequirementService::delete($id)) {
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
        $requirements = RegistrationRequirementService::getAllPaginate($this->search, 15);
        return view('livewire.academic.registration-requirement.list-registration-requirement',compact('requirements'));
    }
}
