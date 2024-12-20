<?php

namespace App\Livewire\Academic\Module;

use App\Constants\Modality;
use App\Constants\ModuleState;
use App\Services\Academic\ModuleService;
use Livewire\Component;

class EditModule extends Component
{
    public $breadcrumbs;
    public $moduleArray = [];
    public $states = [];
    public $modalities = [];
    public $filterProgram = '';
    public $filterTeacher = '';
    public $programsTypes = [];
    public $program;

    public $validate = [
        'moduleArray.codigo' => 'required|unique:program,codigo',
        'moduleArray.nombre' => 'required',
        'moduleArray.sigla' => 'required|string|max:20',
        'moduleArray.version' => 'required|string|max:20',
        'moduleArray.edicion' => 'required|string|max:20',
        'moduleArray.modalidad' => 'required|string|max:50',
        'moduleArray.estado' => 'required|string|max:30',
        // 'moduleArray.costo' => 'numeric',
        'moduleArray.hrs_academicas' => 'integer',
        'moduleArray.fecha_inicio' => 'required|date',
        'moduleArray.fecha_final' => 'required|date',
        'moduleArray.contenido' => 'required',
        'moduleArray.calificacion_docente' => 'numeric',
        'moduleArray.programa_id' => 'required|integer',
        'moduleArray.docente_id' => 'required|integer',
    ];

    public $message = [
        'moduleArray.nombre.required' => 'El nombre es requerido',
        'moduleArray.codigo.required' => 'El código es requerido',
        'moduleArray.codigo.unique' => 'El código ya existe',
        'moduleArray.sigla.required' => 'La sigla es requerida',
        'moduleArray.sigla.string' => 'La sigla debe ser un texto',
        'moduleArray.sigla.max' => 'La sigla debe tener máximo 20 caracteres',
        'moduleArray.version.required' => 'La versión es requerida',
        'moduleArray.version.string' => 'La versión debe ser un texto',
        'moduleArray.version.max' => 'La versión debe tener máximo 20 caracteres',
        'moduleArray.edicion.required' => 'La edición es requerida',
        'moduleArray.edicion.string' => 'La edición debe ser un texto',
        'moduleArray.edicion.max' => 'La edición debe tener máximo 20 caracteres',
        'moduleArray.estado.required' => 'El estado es requerido',
        'moduleArray.estado.string' => 'El estado debe ser un texto',
        'moduleArray.estado.max' => 'El estado debe tener máximo 30 caracteres',
        'moduleArray.contenido.required' => 'El contenido es requerido',
        'moduleArray.modalidad.required' => 'La modalidad es requerida',
        'moduleArray.modalidad.string' => 'La modalidad debe ser un texto',
        'moduleArray.modalidad.max' => 'La modalidad debe tener máximo 50 caracteres',
        'moduleArray.fecha_inicio.required' => 'La fecha de inicio es requerida',
        'moduleArray.fecha_inicio.date' => 'La fecha de inicio debe ser una fecha',
        'moduleArray.fecha_final.required' => 'La fecha final es requerida',
        'moduleArray.fecha_final.date' => 'La fecha final debe ser una fecha',
        // 'moduleArray.costo.required' => 'El costo es requerido',
        // 'moduleArray.costo.numeric' => 'El costo debe ser un número',
        'moduleArray.hrs_academicas.required' => 'Las horas académicas son requeridas',
        'moduleArray.hrs_academicas.integer' => 'Las horas académicas deben ser un número entero',
        'moduleArray.calificacion_docente.nulleable' => 'La calificación del docente debe ser un número',
        'moduleArray.calificacion_docente.numeric' => 'La calificación del docente debe ser un número',
        'moduleArray.programa_id.required' => 'El programa es requerido',
        'moduleArray.programa_id.integer' => 'El programa debe ser un número entero',
        'moduleArray.docente_id.required' => 'El docente es requerido',
        'moduleArray.docente_id.integer' => 'El docente debe ser un número entero',
    ];


    public function mount($module)
    {
        $module = ModuleService::getOne($module);
        $this->program = $module->program;
        $this->moduleArray = [
            'id' => $module->id,
            'codigo' => $module->codigo,
            'nombre' => $module->nombre,
            'sigla' => $module->sigla,
            'version' => $module->version,
            'edicion' => $module->edicion,
            'estado' => $module->estado,
            'modalidad' => $module->modalidad,
            'fecha_inicio' => $module->fecha_inicio,
            'fecha_final' => $module->fecha_final,
            // 'costo' => $module->costo,
            'hrs_academicas' => $module->hrs_academicas,
            'contenido' => $module->contenido,
            'programa_id' => $module->programa_id,
            'docente_id' => $module->docente_id,
            'calificacion_docente' => $module->calificacion_docente,
        ];
        $this->modalities = Modality::all();
        $this->states = ModuleState::all();
        $this->breadcrumbs = [['title' => "Programas", "url" => "program.list"], ['title' => $this->program->sigla, "url" => "program.show", "id" => $this->program->id], ['title' => "Editar modulo", "url" => "module.new", "id" => $module->id]];
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        ModuleService::update($this->moduleArray);
        return redirect()->route('program.show', $this->program->id);
    }

    public function render()
    {
        return view('livewire.academic.module.edit-module');
    }
}
