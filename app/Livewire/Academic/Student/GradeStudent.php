<?php

namespace App\Livewire\Academic\Student;

use App\Services\Academic\ModuleInscriptionService;
use App\Services\Academic\ProgramService;
use App\Services\Academic\StudentService;
use Livewire\Component;

class GradeStudent extends Component
{
    public $breadcrumbs;
    public $student;
    public $modules;
    public $program;

    public function mount($student, $program)
    {
        $this->student = StudentService::getOne($student);
        $this->program = ProgramService::getOne($program);
        $this->modules = ModuleInscriptionService::getAllByStudentAndProgram($student, $program);
        $studentName = $this->student->nombre . " " . $this->student->apellido;
        $this->breadcrumbs = [
            ['title' => "Estudiantes", "url" => "student.list"],
            ['title' => $studentName, "url" => "student.show", "id" => $this->student->id],
            ['title' => "Ver programa", "url" => "program.show", "id" => $this->program->id]
        ];
    }

    public function render()
    {
        return view('livewire.academic.student.grade-student');
    }
}
