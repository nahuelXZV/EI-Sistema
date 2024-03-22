<?php

namespace App\Livewire\Academic\Program;

use App\Constants\ModuleState;
use App\Services\Academic\ModuleInscriptionService;
use App\Services\Academic\ModuleProcessService;
use App\Services\Academic\ModuleService;
use Livewire\Component;
use Livewire\WithPagination;

class ModuleProgram extends Component
{
    use WithPagination;
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
        if (ModuleProcessService::processDone($this->module, $procesoId)) {
            return $this->render();
        }
    }

    public function initModule()
    {
        $this->module->estado = ModuleState::EN_PROCESO;
        $this->module->save();
        $this->module = ModuleService::getOne($this->module->id);
    }

    public function finishModule()
    {
        $this->module->estado = ModuleState::FINALIZADO;
        $this->module->save();
        $this->module = ModuleService::getOne($this->module->id);
    }

    public function render()
    {
        $students = ModuleInscriptionService::getAllByModulePaginate($this->module->id);
        $processes = ModuleProcessService::getProcesses($this->module);
        return view('livewire.academic.program.module-program', compact('processes', 'students'));
    }
}
