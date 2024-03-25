<?php

namespace App\Livewire\Academic\RegistrationRequirement;

use App\Constants\ImportanceRequirement;
use App\Services\Academic\RegistrationRequirementService;
use Livewire\Component;

class EditRegistrationRequirement extends Component
{
    public $breadcrumbs = [['title' => "Requisitos", "url" => "requirement.list"], ['title' => "Crear", "url" => "requirement.create"]];
    public $requirementArray = [];
    public $importances = [];

    public $message = [
        'requirementArray.nombre.required' => 'El nombre es requerido',
        'requirementArray.importancia.required' => 'La importancia es requerida',
    ];

    public function mount($requirement)
    {
        $this->requirementArray = RegistrationRequirementService::getOne($requirement)->toArray();
        $this->importances = ImportanceRequirement::all();
    }

    public function save()
    {
        $this->validate([
            'requirementArray.nombre' => 'required',
            'requirementArray.importancia' => 'required',
        ], $this->message);
        RegistrationRequirementService::update($this->requirementArray);
        return redirect()->route('requirement.list');
    }

    public function render()
    {
        return view('livewire.academic.registration-requirement.edit-registration-requirement');
    }
}
