<?php

namespace App\Livewire\Academic\Course;

use App\Services\Academic\CourseInscriptionService;
use App\Services\Academic\CourseService;
use Livewire\Component;

class GradeCourse extends Component
{
    public $course;
    public $breadcrumbs;
    public $arrayStudentsInscription = [];
    public $grades = [];
    public $observations = [];
    public $arrayError = [];

    public function mount($course)
    {
        $this->course = CourseService::getOne($course);
        $this->arrayStudentsInscription = CourseInscriptionService::getAllStudentAndGradeByCourse($this->course->id);
        foreach ($this->arrayStudentsInscription as $student) {
            $this->grades[$student->id] = $student->nota ?? 0;
            $this->observations[$student->id] = $student->observacion;
        }
        $this->arrayError = [
            "hasError" => false,
            "message" => "Las notas deben ser entre 0 y 100",
            "idStudent" => 0
        ];
        $this->breadcrumbs = [
            ['title' => "Cursos", "url" => "course.list"],
            ['title' => "Ver", "url" => "course.show", "id" => $this->course->id],
            ['title' => "Notas", "url" => "course.grade", "id" => $this->course->id]
        ];
    }

    public function save()
    {
        $this->arrayError['hasError'] = false;
        foreach ($this->grades as $key => $value) {
            if (!is_numeric($value) || $value < 0 || $value > 100) {
                $this->arrayError['hasError'] = true;
                $this->arrayError['idStudent'] = $key;
                $this->arrayStudentsInscription = CourseInscriptionService::getAllStudentAndGradeByCourse($this->course->id);
                return;
            }
        }
        foreach ($this->grades as $key => $nota) {
            $courseInscription = CourseInscriptionService::getOneByStudentAndCourse($key, $this->course->id);
            CourseInscriptionService::updateGrade([
                "nota" => $nota,
                "observacion" => $this->observations[$key],
                "id" => $courseInscription->id
            ]);
        }
        return redirect()->route('course.show', [$this->course->id]);
    }

    public function render()
    {
        return view('livewire..academic.course.grade-course');
    }
}
