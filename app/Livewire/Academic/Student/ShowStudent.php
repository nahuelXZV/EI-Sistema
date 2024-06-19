<?php

namespace App\Livewire\Academic\Student;

use App\Constants\StateStudent;
use App\Services\Academic\CourseInscriptionService;
use App\Services\Academic\ProgramInscriptionService;
use App\Services\Academic\RegistrationRequirementService;
use App\Services\Academic\StudentService;
use Livewire\Component;

class ShowStudent extends Component
{
    public $breadcrumbs = [['title' => "Estudiantes", "url" => "student.list"], ['title' => "Ver", "url" => "student.show"]];

    public $student;

    public function mount($student)
    {
        $this->student = StudentService::getOne($student);
    }

    public function changeState()
    {
        if ($this->student->estado == StateStudent::INACTIVE) {
            $this->student->fecha_inactividad = null;
            $this->student->estado = StateStudent::ACTIVE;
        } else {
            $this->student->fecha_inactividad = date('Y-m-d');
            $this->student->estado = StateStudent::INACTIVE;
        }
        $this->student->save();
        $this->student = StudentService::getOne($this->student->id);
    }

    public function deleteRequirement($id)
    {
        if (RegistrationRequirementService::deleteRequirement($id)) {
            $this->render();
        }
    }

    public function render()
    {
        $programs = ProgramInscriptionService::getAllByStudentPaginate($this->student->id);
        $courses = CourseInscriptionService::getAllByStudentInscriptionPaginate($this->student->id);
        $requirements = RegistrationRequirementService::getRequirementsDone($this->student);
        return view('livewire.academic.student.show-student', compact('programs', 'requirements', 'courses'));
    }
}
