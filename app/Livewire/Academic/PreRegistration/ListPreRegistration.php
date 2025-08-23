<?php

namespace App\Livewire\Academic\PreRegistration;

use App\Services\Marketing\PreRegistrationService;
use Livewire\Component;
use Livewire\WithPagination;

class ListPreRegistration extends Component
{
    use WithPagination;
    protected $listeners = ['cleanerNotificacion'];

    public $breadcrumbs = [['title' => "Pre Registros", "url" => "preregistration.list"]];
    public $search = '';
    public $notificacion = false;
    public $type = '';
    public $message = '';

    public function mount() {}

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
        if (PreRegistrationService::delete($id)) {
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
        $students = PreRegistrationService::getAllPaginate($this->search, 15);
        return view('livewire.academic.pre-registration.list-pre-registration', compact('students'));
    }
}
