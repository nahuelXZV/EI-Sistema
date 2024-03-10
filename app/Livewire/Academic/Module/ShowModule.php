<?php

namespace App\Livewire\Academic\Module;

use App\Services\Academic\ModuleService;
use Livewire\Component;

class ShowModule extends Component
{
    public $breadcrumbs = [['title' => "Modulos", "url" => "module.list"], ['title' => "Ver", "url" => "module.show"]];

    public $module;
    public $program;
    public $teacher;

    public function mount($module)
    {
        $this->module = ModuleService::getOne($module);
        $this->program = $this->module->program;
        $this->teacher = $this->module->teacher;
    }

    public function render()
    {
        return view('livewire.academic.module.show-module');
    }
}
