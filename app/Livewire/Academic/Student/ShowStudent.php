<?php

namespace App\Livewire\Academic\Student;

use App\Constants\StateStudent;
use App\Services\Academic\ProgramService;
use App\Services\Academic\StudentService;
use Livewire\Component;

class ShowStudent extends Component
{
    public $breadcrumbs = [['title' => "Estudiantes", "url" => "student.list"], ['title' => "Ver", "url" => "teacstudenther.show"]];

    public $student;
    public $programs;

    public function mount($student)
    {
        $this->student = StudentService::getOne($student);
        // $this->programs = ProgramService::getProgramsByStudent($student);
        $this->programs = [];
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

    public function render()
    {
        return view('livewire.academic.student.show-student');
    }
}
