<?php

namespace App\Livewire\Academic\Teacher;

use App\Services\Academic\TeacherService;
use Livewire\Component;
use Livewire\WithPagination;

class ListTeacher extends Component
{
    use WithPagination;
    protected $listeners = ['cleanerNotificacion'];

    public $breadcrumbs = [['title' => "Docentes", "url" => "teacher.list"]];
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
        if (TeacherService::delete($id)) {
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
        $teachers = TeacherService::getAllPaginate($this->search, 15);
        return view('livewire.academic.teacher.list-teacher', compact('teachers'));
    }
}
