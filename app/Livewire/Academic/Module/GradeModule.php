<?php

namespace App\Livewire\Academic\Module;

use App\Models\Module;
use App\Services\Academic\ModuleInscriptionService;
use App\Services\Academic\ModuleService;
use Dotenv\Parser\Parser;
use Livewire\Component;

class GradeModule extends Component
{
    public $module;
    public $program;
    public $breadcrumbs;
    public $arrayStudentsInscription = [];
    public $grades = [];
    public $observations = [];
    public $arrayError = [];

    public function mount($module)
    {
        $this->module = ModuleService::getOne($module);
        $this->program = $this->module->program;
        $this->arrayStudentsInscription = ModuleInscriptionService::getAllStudentAndGradeByModule($this->module->id);
        foreach ($this->arrayStudentsInscription as $student) {
            $this->grades[$student->id] = $student->nota ?? 0;
            $this->observations[$student->id] = $student->observacion;
        }
        $this->arrayError = [
            "hasError" => false,
            "message" => "Las notas deben ser entre 0 y 100",
            "idStudent" => 0
        ];
        $this->breadcrumbs = [
            ['title' => "Programas", "url" => "program.list"],
            ['title' => $this->program->sigla, "url" => "program.show", "id" => $this->program->id],
            ['title' => "Modulo", "url" => "program.module", "id" => $this->program->id],
            ['title' => "Notas", "url" => "module.grade", "id" => $this->module->id]
        ];
    }

    public function save()
    {
        $this->arrayError['hasError'] = false;
        foreach ($this->grades as $key => $value) {
            if (!is_numeric($value) || $value < 0 || $value > 100) {
                $this->arrayError['hasError'] = true;
                $this->arrayError['idStudent'] = $key;
                $this->arrayStudentsInscription = ModuleInscriptionService::getAllStudentAndGradeByModule($this->module->id);
                return;
            }
        }
        foreach ($this->grades as $key => $nota) {
            $moduleInscription = ModuleInscriptionService::getOneByStudentAndModule($key, $this->module->id);
            ModuleInscriptionService::updateGrade([
                "nota" => $nota,
                "observacion" => $this->observations[$key],
                "id" => $moduleInscription->id
            ]);
        }
        return redirect()->route('program.module', [$this->module->id]);
    }

    public function render()
    {
        return view('livewire.academic.module.grade-module');
    }
}
