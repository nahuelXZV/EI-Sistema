<?php

namespace App\Livewire\Accounting\Program;

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


    public function render()
    {
        $programs = ProgramService::getAllPaginate($this->search, 15);
        return view('livewire.accounting.program.list-program', compact('programs'));
    }
}
