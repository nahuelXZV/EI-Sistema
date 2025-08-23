<?php

namespace App\Livewire\Marketing\Program;

use App\Services\Academic\ModuleService;
use App\Services\Academic\ProgramService;
use App\Services\Marketing\PreRegistrationService;
use Livewire\Component;
use Livewire\WithPagination;

class ShowProgramOffer extends Component
{
    use WithPagination;
    public $breadcrumbs = [['title' => "Programas en oferta", "url" => "program-offer.list"], ['title' => "Ver", "url" => "program-offer.show"]];

    public $program;
    public $numberModulesInProgress;
    public $link_form_inscription = '';
    public $url_web_student = '';

    public function mount($program)
    {
        $this->program = ProgramService::getOne($program);
        $this->numberModulesInProgress = ModuleService::getNumberModulesInProgress($this->program->id);
    }

    public function render()
    {
        $modules = ModuleService::getAllByProgramPaginateSecond($this->program->id);
        $preRegistrations = PreRegistrationService::getAllByProgramPaginate($this->program->id);
        return view('livewire.marketing.program.show-program-offer', compact('modules', 'preRegistrations'));
    }
}
