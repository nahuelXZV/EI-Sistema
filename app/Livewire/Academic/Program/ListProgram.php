<?php

namespace App\Livewire\Academic\Program;

use App\Services\Academic\ProgramService;
use Livewire\Component;
use Livewire\WithPagination;

class ListProgram extends Component
{
    use WithPagination;
    protected $listeners = ['cleanerNotificacion'];

    public $breadcrumbs = [['title' => "Programas", "url" => "program.list"]];
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
        if (ProgramService::delete($id)) {
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
        $programs = ProgramService::getAllPaginate($this->search, 15);
        return view('livewire.academic.program.list-program', compact('programs'));
    }
}
