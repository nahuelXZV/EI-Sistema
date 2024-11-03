<?php

namespace App\Livewire\Academic\Contract;

use App\Services\Academic\ContractService;
use App\Services\Academic\CourseService;
use App\Services\Academic\ModuleService;
use App\Services\Academic\TeacherService;
use Livewire\Component;

class EditContract extends Component
{
    public $breadcrumbs;
    public $teacher;
    public $contract;

    public $contractArray = [];
    public $modulos = [];
    public $cursos = [];

    public $validate = [
        'contractArray.honorarios' => 'required',
        'contractArray.fecha_inicio' => 'required',
        'contractArray.fecha_fin' => 'required',
        'contractArray.horario' => 'required',
        'contractArray.nro_preventiva' => 'required',
    ];

    public $message = [
        'contractArray.honorarios.required' => 'El honorario es requerido',
        'contractArray.fecha_inicio.required' => 'La fecha de inicio es requerida',
        'contractArray.fecha_fin.required' => 'La fecha de fin es requerida',
        'contractArray.horario.required' => 'El horario es requerido',
        'contractArray.nro_preventiva.required' => 'El número de preventiva es requerido',
    ];

    public function mount($contract)
    {
        $this->contract = ContractService::getOne($contract);
        $this->teacher = TeacherService::getOne($this->contract->docente_id);
        $this->modulos = ModuleService::getAllWithoutContract($this->contract->docente_id);
        $this->cursos = CourseService::getAllWithoutContract($this->contract->docente_id);
        $nameTeacher = $this->teacher->nombre . ' ' . $this->teacher->apellido;
        $this->breadcrumbs = [
            ['title' => "Docentes", "url" => "teacher.list"], // docente
            ['title' => $nameTeacher, "url" => "teacher.show", "id" => $this->contract->docente_id], // docente
            ['title' => "Contrato", "url" => "contract.new", "id" => $this->contract->docente_id], // contrato
            ['title' => "Crear", "url" => "contract.new", "id" => $this->contract->docente_id] // contrato
        ];
        $this->contractArray = [
            'id' => $this->contract->id,
            'honorarios' => $this->contract->honorarios,
            'fecha_inicio' => $this->contract->fecha_inicio,
            'fecha_fin' =>  $this->contract->fecha_fin,
            'horario' => $this->contract->horario,
            'nro_preventiva' => $this->contract->nro_preventiva,
            'modulo_id' => $this->contract->modulo_id,
            'curso_id' => $this->contract->curso_id,
        ];
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        ContractService::update($this->contractArray);
        return redirect()->route('teacher.show', $this->teacher->id);
    }

    public function render()
    {
        return view('livewire.academic.contract.edit-contract');
    }
}
