<?php

namespace App\Livewire\Academic\Student;

use App\Services\Academic\StudentService;
use Livewire\Component;
use Livewire\WithPagination;

class ListStudent extends Component
{
    use WithPagination;
    protected $listeners = ['cleanerNotificacion'];

    public $breadcrumbs = [['title' => "Estudiantes", "url" => "student.list"]];
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
        if (StudentService::delete($id)) {
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
        $students = StudentService::getAllPaginate($this->search, 15);
        return view('livewire.academic.student.list-student', compact('students'));
    }
}
