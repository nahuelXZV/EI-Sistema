<?php

namespace App\Livewire\Academic\Program;

use App\Services\Academic\ProgramService;
use Livewire\Component;

class ShowProgram extends Component
{

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
        return view('livewire.academic.program.show-program');
    }
}
