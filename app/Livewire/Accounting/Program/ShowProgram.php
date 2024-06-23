<?php

namespace App\Livewire\Accounting\Program;

use App\Services\Academic\ModuleService;
use App\Services\Academic\ProgramService;
use App\Services\Accounting\ProgramPaymentService;
use Livewire\Component;
use Livewire\WithPagination;

class ShowProgram extends Component
{
    use WithPagination;
    public $breadcrumbs = [['title' => "Programas", "url" => "program-payment.program.list"], ['title' => "Ver", "url" => "program-payment.program.show"]];

    public $program;
    public $numberModulesInProgress;

    public function mount($program)
    {
        $this->program = ProgramService::getOne($program);
        $this->numberModulesInProgress = ModuleService::getNumberModulesInProgress($this->program->id);
    }

    public function render()
    {
        $students = ProgramPaymentService::getAllStudentsByProgram($this->program->id);
        return view('livewire.accounting.program.show-program', compact('students'));
    }
}
