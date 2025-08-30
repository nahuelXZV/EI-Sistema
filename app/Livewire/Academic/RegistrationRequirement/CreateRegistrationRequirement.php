<?php

namespace App\Livewire\Academic\RegistrationRequirement;

use App\Constants\ImportanceRequirement;
use App\Services\Academic\RegistrationRequirementService;
use Livewire\Component;

class CreateRegistrationRequirement extends Component
{
    public $breadcrumbs = [['title' => "Requisitos", "url" => "requirement.list"], ['title' => "Crear", "url" => "requirement.create"]];
    public $requirementArray = [];

    public $validate = [
        'requirementArray.nombre' => 'required',
        'requirementArray.requerido' => 'required',
    ];

    public $message = [
        'requirementArray.nombre.required' => 'El nombre es requerido',
        'requirementArray.requerido.required' => 'El campo requerido es obligatorio',
    ];

    public function mount()
    {
        $this->requirementArray = [
            'nombre' => '',
            'requerido' => false,
        ];
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        RegistrationRequirementService::create($this->requirementArray);
        return redirect()->route('requirement.list');
    }

    public function render()
    {
        return view('livewire.academic.registration-requirement.create-registration-requirement');
    }
}
