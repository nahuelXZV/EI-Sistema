<?php

namespace App\Livewire\Academic\Contract;

use App\Services\Academic\ContractService;
use App\Services\Academic\CourseService;
use App\Services\Academic\LetterService;
use App\Services\Academic\ModuleService;
use App\Services\Academic\TeacherService;
use Livewire\Component;

class ShowContract extends Component
{
    public $breadcrumbs;

    public $contract;
    public $teacher;
    public $module;
    public $course;
    public $letters;

    public function mount($contract)
    {
        $this->contract = ContractService::getOne($contract);
        $this->teacher = TeacherService::getOne($this->contract->docente_id);
        if ($this->contract->modulo_id) {
            $this->module = ModuleService::getOne($this->contract->modulo_id);
        } else {
            $this->course = CourseService::getOne($this->contract->curso_id);
        }
        $this->letters = LetterService::getAllByContract($contract);
        $nameTeacher = $this->teacher->nombre . ' ' . $this->teacher->apellido;
        $this->breadcrumbs = [
            ['title' => "Docentes", "url" => "teacher.list"], // docente
            ['title' => $nameTeacher, "url" => "teacher.show", "id" => $this->teacher->id], // docente
            ['title' => "Contrato", "url" => "contract.show", "id" => $this->contract->id], // contrato
            ['title' => "Ver", "url" => "contract.show", "id" => $this->contract->id] // contrato
        ];
    }

    public function delete($id)
    {
        LetterService::delete($id);
        $this->letters = LetterService::getAllByContract($this->contract->id);
    }

    public function updateLetters()
    {
        $updated =  ContractService::updateLetters($this->contract->id);
        if ($updated) {
            $this->letters = LetterService::getAllByContract($this->contract->id);
        }
    }

    public function render()
    {
        return view('livewire.academic.contract.show-contract');
    }
}
