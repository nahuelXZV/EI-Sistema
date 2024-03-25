<?php

namespace App\Livewire\Academic\Program;

use App\Services\Academic\ModuleService;
use App\Services\Academic\ProgramInscriptionService;
use App\Services\Academic\ProgramService;
use Livewire\Component;
use Livewire\WithPagination;

class ShowProgram extends Component
{
    use WithPagination;
    public $breadcrumbs = [['title' => "Programas", "url" => "program.list"], ['title' => "Ver", "url" => "program.show"]];

    public $program;

    public function toggleGraph()
    {
        $this->program->has_grafica = !$this->program->has_grafica;
        $this->program->save();
    }

    public function mount($program)
    {
        $this->program = ProgramService::getOne($program);
    }

    public function render()
    {
        $students = ProgramInscriptionService::getAllByProgramPaginate("", $this->program->id);
        $modules = ModuleService::getAllByProgramPaginate($this->program->id);
        return view('livewire.academic.program.show-program', compact('students', 'modules'));
    }
}
