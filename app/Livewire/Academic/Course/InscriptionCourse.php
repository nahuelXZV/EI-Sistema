<?php

namespace App\Livewire\Academic\Course;

use App\Services\Academic\CourseInscriptionService;
use App\Services\Academic\CourseService;
use App\Services\Academic\StudentService;
use Livewire\Component;
use Livewire\WithPagination;

class InscriptionCourse extends Component
{
    use WithPagination;
    public $breadcrumbs;
    public $course;
    public $search = '';
    public $listStudent = [];

    public function mount($course)
    {
        $this->course = CourseService::getOne($course);
        $this->breadcrumbs = [
            ['title' => "Curso", "url" => "course.list"],
            ['title' => "Ver", "url" => "course.show", "id" => $this->course->id],
            ['title' => "Inscribir", "url" => "course.inscription", "id" => $this->course->id]
        ];

        $listInscription = CourseInscriptionService::getAllByCourse($this->course->id);
        foreach ($listInscription as $inscrito) {
            array_push($this->listStudent, $inscrito->estudiante_id);
        }
    }

    public function save()
    {
        foreach ($this->listStudent as $estudiante) {
            $exist = CourseInscriptionService::getOneByStudentAndCourse($estudiante, $this->course->id);
            if ($exist) continue;
            CourseInscriptionService::create([
                'fecha' => date('Y-m-d'),
                'nota' => 0,
                'observacion' => '',
                'estudiante_id' => $estudiante,
                'curso_id' => $this->course->id
            ]);
        }
        $studentsInscriptions = CourseInscriptionService::getAllByCourse($this->course->id);
        foreach ($studentsInscriptions as $inscrito) {
            if (!in_array($inscrito->estudiante_id, $this->listStudent)) $inscrito->delete();
        }
        return redirect()->route('course.show', $this->course->id);
    }

    public function add($student)
    {
        if (in_array($student, $this->listStudent)) {
            $this->listStudent = array_diff($this->listStudent, [$student]);
        } else {
            array_push($this->listStudent, $student);
        }
    }

    public function render()
    {
        $students = StudentService::getAllPaginate($this->search, 15);
        return view('livewire..academic.course.inscription-course', compact('students'));
    }
}
