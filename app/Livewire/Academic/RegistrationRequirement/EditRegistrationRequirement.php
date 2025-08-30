<?php

namespace App\Livewire\Academic\RegistrationRequirement;

use App\Services\Academic\RegistrationRequirementService;
use Livewire\Component;

class EditRegistrationRequirement extends Component
{
    public $breadcrumbs = [['title' => "Requisitos", "url" => "requirement.list"], ['title' => "Crear", "url" => "requirement.create"]];
    public $requirementArray = [];

    public $message = [
        'requirementArray.nombre.required' => 'El nombre es requerido',
        'requirementArray.requerido.required' => 'El campo requerido es obligatorio',
    ];

    public function mount($requirement)
    {
        $this->requirementArray = RegistrationRequirementService::getOne($requirement)->toArray();
    }

    public function save()
    {
        $this->validate([
            'requirementArray.nombre' => 'required',
            'requirementArray.requerido' => 'required',
        ], $this->message);
        RegistrationRequirementService::update($this->requirementArray);
        return redirect()->route('requirement.list');
    }

    public function render()
    {
        return view('livewire.academic.registration-requirement.edit-registration-requirement');
    }
}
