<?php

namespace App\Livewire\Academic\Course;

use App\Services\Academic\CourseInscriptionService;
use App\Services\Academic\CourseService;
use Livewire\Component;
use Livewire\WithPagination;

class ShowCourse extends Component
{
    use WithPagination;
    public $breadcrumbs = [['title' => "Cursos", "url" => "course.list"], ['title' => "Ver", "url" => "course.show"]];
    public $course;
    public $search = '';

    public function mount($course)
    {
        $this->course = CourseService::getOne($course);
    }

    public function render()
    {
        $students = CourseInscriptionService::getAllByCoursePaginate($this->course->id);
        return view('livewire..academic.course.show-course',compact('students'));
    }
}
