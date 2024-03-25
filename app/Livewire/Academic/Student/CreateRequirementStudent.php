<?php

namespace App\Livewire\Academic\Student;

use App\Services\Academic\RegistrationRequirementService;
use App\Services\Academic\StudentService;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateRequirementStudent extends Component
{
    use WithFileUploads;
    public $breadcrumbs = [];
    public $student;
    public $documents = [];

    public function mount($student)
    {
        $this->student = StudentService::getOne($student);
        $this->breadcrumbs = [['title' => "Estudiantes", "url" => "student.list"],  ['title' => "Ver", "url" => "student.show", "id" => $this->student->id],['title' => "Requisito", "url" => "student.requirement"]];
    }

    public function save()
    {
        if ($this->documents) {
            RegistrationRequirementService::saveDocuments($this->documents, $this->student);
            return redirect()->route('student.show', ['student' => $this->student->id]);
        }
    }

    public function render()
    {
        $requirements = RegistrationRequirementService::getRequirementsNotDone($this->student);
        return view('livewire..academic.student.create-requirement-student',compact('requirements'));
    }
}
