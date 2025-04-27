<?php

namespace App\Livewire\Academic\Program;

use App\Models\Forms\PostgraduateForm;
use App\Services\Academic\ProgramService;
use App\Services\Academic\RegistrationFormService;
use Livewire\Component;

class UpdateRegistrationForm extends Component
{
    public $breadcrumbs = [['title' => "Programas", "url" => "program.list"], ['title' => "Actualizar Formulario de Inscripción", "url" => "program.update-registration-form"]];
    public $program;
    public $registrationForm;
    public $postgraduateForm = [];

    public function mount($registration)
    {
        $this->registrationForm = RegistrationFormService::getOne($registration);
        $this->program = ProgramService::getOne($this->registrationForm->programa_id);
        $this->postgraduateForm = PostgraduateForm::sync($this->registrationForm);
    }

    public function save()
    {
        $this->validate(PostgraduateForm::rules(), PostgraduateForm::messages());
        RegistrationFormService::update($this->postgraduateForm);
        return redirect()->route('program.show', $this->program->id);
    }

    public function render()
    {
        return view('livewire.academic.program.update-registration-form');
    }
}
