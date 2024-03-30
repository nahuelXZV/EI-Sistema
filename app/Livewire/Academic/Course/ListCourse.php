<?php

namespace App\Livewire\Academic\Course;

use App\Services\Academic\CourseService;
use Livewire\Component;
use Livewire\WithPagination;

class ListCourse extends Component
{
    use WithPagination;
    protected $listeners = ['cleanerNotificacion'];

    public $breadcrumbs = [['title' => "Cursos", "url" => "course.list"]];
    public $search = '';
    public $notificacion = false;
    public $type = '';
    public $message = '';

    public function mount()
    {
    }

    public function cleanerNotificacion()
    {
        $this->notificacion = null;
        $this->search = '';
        $this->type = '';
    }

    public function updatingAttribute()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        if (CourseService::delete($id)) {
            $this->message = 'Eliminado correctamente';
            $this->type = 'success';
        } else {
            $this->message = 'Error al eliminar';
            $this->type = 'error';
        }
        $this->notificacion = true;
    }
    public function render()
    {
        $courses = CourseService::getAllPaginate($this->search, 15);
        return view('livewire..academic.course.list-course',compact('courses'));
    }
}
