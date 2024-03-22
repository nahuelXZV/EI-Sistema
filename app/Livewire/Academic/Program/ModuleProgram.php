<?php

namespace App\Livewire\Academic\Program;

use App\Services\Academic\ModuleProcessService;
use App\Services\Academic\ModuleService;
use Livewire\Component;

class ModuleProgram extends Component
{
    public $breadcrumbs = [];

    public $module;
    public $program;
    public $teacher;

    public function mount($module)
    {
        $this->module = ModuleService::getOne($module);
        $this->program = $this->module->program;
        $this->teacher = $this->module->teacher;
        $this->breadcrumbs = [['title' => "Programas", "url" => "program.list"], ['title' => $this->program->sigla, "url" => "program.show", "id" => $this->program->id], ['title' => "Ver modulo", "url" => "program.module", "id" => $this->module->id]];
    }

    public function process($procesoId)
    {
        if(ModuleProcessService::processDone($this->module, $procesoId) ){
            return $this->render();
        }
    }

    public function render()
    {
        $processes = ModuleProcessService::getProcesses($this->module);
        return view('livewire.academic.program.module-program', compact('processes'));
    }
}
