<?php

namespace App\Livewire\Academic\PreRegistration;

use App\Services\Academic\CareerService;
use App\Services\Academic\ProgramService;
use App\Services\Academic\UniversityService;
use App\Services\Accounting\DiscountTypeService;
use App\Services\Marketing\PreRegistrationService;
use Livewire\Component;

class ShowPreRegistration extends Component
{
    public $breadcrumbs = [['title' => "Pre Registros", "url" => "preregistration.list"], ['title' => "Ver", "url" => "preregistration.show"]];
    protected $listeners = ['cleanerNotificacion'];
    public $registration;
    public $program;
    public $university;
    public $carrer;
    public $discount;
    public $notificacion = false;
    public $type = '';
    public $message = '';

    public function mount($registration)
    {
        $this->registration = PreRegistrationService::getOne($registration);
        $this->program = ProgramService::getOne($this->registration->programa_id);
        if ($this->registration->descuento_id) {
            $this->discount = DiscountTypeService::getOne($this->registration->descuento_id);
        }
        $this->university = UniversityService::getOne($this->registration->universidad_id);
        $this->carrer = CareerService::getOne($this->registration->carrera_id);
    }

    public function cleanerNotificacion()
    {
        $this->notificacion = null;
        $this->type = '';
    }

    public function approve()
    {
        $result = PreRegistrationService::approvePreRegistration($this->registration->id);
        if ($result != null && $result != 0) {
            $this->message = 'Preinscripción aprobada con éxito.';
        } else {
            $this->message = 'Error al aprobar la preinscripción.';
            $this->type = 'error';
            $this->notificacion = true;
            return;
        }

        redirect()->route('student.show', $result);
    }

    public function render()
    {
        return view('livewire.academic.pre-registration.show-pre-registration');
    }
}
