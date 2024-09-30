<?php

namespace App\Livewire\Academic\Contract;

use App\Services\Academic\ContractService;
use App\Services\Academic\CourseService;
use App\Services\Academic\ModuleService;
use App\Services\Academic\TeacherService;
use Livewire\Component;

class CreateContract extends Component
{
    public $breadcrumbs;
    public $teacher;
    public $tipo;

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

    public function mount($teacher)
    {
        $this->teacher = TeacherService::getOne($teacher);
        $this->modulos = ModuleService::getAllWithoutContract();
        $this->cursos = CourseService::getAllWithoutContract();
        $nameTeacher = $this->teacher->nombre . ' ' . $this->teacher->apellido;
        $this->breadcrumbs = [
            ['title' => "Docentes", "url" => "teacher.list"], // docente
            ['title' => $nameTeacher, "url" => "teacher.show", "id" => $teacher], // docente
            ['title' => "Contrato", "url" => "contract.new", "id" => $teacher], // contrato
            ['title' => "Crear", "url" => "contract.new", "id" => $teacher] // contrato
        ];
        $this->contractArray = [
            'honorarios' => null,
            'fecha_inicio' => '',
            'fecha_fin' => '',
            'horario' => '',
            'nro_preventiva' => '',
            'docente_id' => $teacher,
            'modulo_id' => '',
            'curso_id' => '',
        ];
        $this->tipo = 'modulo';
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        if ($this->tipo == 'modulo') {
            $this->contractArray['curso_id'] = null;
            if ($this->contractArray['modulo_id'] == null)
                $this->validate(['contractArray.modulo_id' => 'required',], ['contractArray.modulo_id.required' => 'El módulo es requerido',]);
        } else {
            $this->contractArray['modulo_id'] = null;
            if ($this->contractArray['curso_id'] == null)
                $this->validate(['contractArray.curso_id' => 'required',], ['contractArray.curso_id.required' => 'El curso es requerido',]);
        }

        ContractService::create($this->contractArray);
        return redirect()->route('teacher.show', $this->teacher->id);
    }

    public function render()
    {
        return view('livewire.academic.contract.create-contract');
    }
}
