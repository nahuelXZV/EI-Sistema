<?php

namespace App\Livewire\Academic\Module;

use App\Services\Academic\ModuleService;
use App\Services\Academic\ModuleInscriptionService;
use App\Services\Academic\ProgramInscriptionService;
use Livewire\Component;
use Livewire\WithPagination;

class InscriptionModule extends Component
{
    use WithPagination;
    public $breadcrumbs;
    public $module;
    public $program;
    public $search = '';
    public $listStudent = [];

    public function mount($module)
    {
        $this->module = ModuleService::getOne($module);
        $this->program = $this->module->program;
        $this->breadcrumbs = [
            ['title' => "Programas", "url" => "program.list"],
            ['title' => $this->program->sigla, "url" => "program.show", "id" => $this->program->id],
            ['title' => "Modulo", "url" => "program.module", "id" => $this->program->id],
            ['title' => "Inscribir", "url" => "program.inscription", "id" => $this->module->id]
        ];
        $listInscription = ModuleInscriptionService::getAllByModule($this->module->id);
        foreach ($listInscription as $inscrito) {
            array_push($this->listStudent, $inscrito->estudiante_id);
        }
    }

    public function save()
    {
        foreach ($this->listStudent as $estudiante) {
            $exist = ModuleInscriptionService::getOneByStudentAndModule($estudiante, $this->module->id);
            if ($exist) continue;
            ModuleInscriptionService::create([
                'fecha' => date('Y-m-d'),
                'nota' => 0,
                'observacion' => '',
                'estudiante_id' => $estudiante,
                'modulo_id' => $this->module->id
            ]);
        }
        // eliminar los que no estan en el array
        $studentsInscriptions = ModuleInscriptionService::getAllByModule($this->module->id);
        foreach ($studentsInscriptions as $inscrito) {
            if (!in_array($inscrito->estudiante_id, $this->listStudent)) $inscrito->delete();
        }
        return redirect()->route('program.module', $this->module->id);
    }

    public function add($student)
    {
        // esta el valor de estudiante en el array
        if (in_array($student, $this->listStudent)) {
            // eliminar el valor del array
            $this->listStudent = array_diff($this->listStudent, [$student]);
        } else {
            // agregar el valor al array
            array_push($this->listStudent, $student);
        }
    }


    public function render()
    {
        $students = ProgramInscriptionService::getAllByProgramPaginate($this->search, $this->program->id);
        // falta restringir si tiene deudas o no
        return view('livewire.academic.module.inscription-module', compact('students'));
    }
}
