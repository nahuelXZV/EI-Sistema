<?php

namespace App\Livewire\Academic\Program;

use App\Constants\Modality;
use App\Constants\ProgramsTypes;
use App\Models\Program;
use App\Services\Academic\ProgramService;
use Livewire\Component;

class EditProgram extends Component
{
    public $breadcrumbs = [['title' => "Programas", "url" => "program.list"], ['title' => "Editar", "url" => "program.create"]];
    public $program;
    public $programArray = [];
    public $programsTypes = [];
    public $modalities = [];

    public $message = [
        'programArray.nombre.required' => 'El nombre es requerido',
        'programArray.codigo.unique' => 'El código ya existe',
        'programArray.sigla.required' => 'La sigla es requerida',
        'programArray.sigla.string' => 'La sigla debe ser un texto',
        'programArray.sigla.max' => 'La sigla debe tener máximo 20 caracteres',
        'programArray.version.required' => 'La versión es requerida',
        'programArray.version.string' => 'La versión debe ser un texto',
        'programArray.version.max' => 'La versión debe tener máximo 20 caracteres',
        'programArray.edicion.required' => 'La edición es requerida',
        'programArray.edicion.string' => 'La edición debe ser un texto',
        'programArray.edicion.max' => 'La edición debe tener máximo 20 caracteres',
        'programArray.tipo.required' => 'El tipo es requerido',
        'programArray.tipo.string' => 'El tipo debe ser un texto',
        'programArray.tipo.max' => 'El tipo debe tener máximo 50 caracteres',
        'programArray.modalidad.required' => 'La modalidad es requerida',
        'programArray.modalidad.string' => 'La modalidad debe ser un texto',
        'programArray.modalidad.max' => 'La modalidad debe tener máximo 50 caracteres',
        'programArray.fecha_inicio.required' => 'La fecha de inicio es requerida',
        'programArray.fecha_inicio.date' => 'La fecha de inicio debe ser una fecha',
        'programArray.fecha_final.required' => 'La fecha final es requerida',
        'programArray.fecha_final.date' => 'La fecha final debe ser una fecha',
        'programArray.costo.required' => 'El costo es requerido',
        'programArray.costo.numeric' => 'El costo debe ser un número',
        'programArray.hrs_academicas.required' => 'Las horas académicas son requeridas',
        'programArray.hrs_academicas.integer' => 'Las horas académicas deben ser un número entero',
        'programArray.cantidad_modulos.required' => 'La cantidad de módulos es requerida',
        'programArray.cantidad_modulos.integer' => 'La cantidad de módulos debe ser un número entero',
    ];

    public function mount($program)
    {
        $this->program = Program::find($program);
        $this->programArray = [
            'id' => $this->program->id,
            'codigo' => $this->program->codigo,
            'nombre' => $this->program->nombre,
            'sigla' => $this->program->sigla,
            'version' => $this->program->version,
            'edicion' => $this->program->edicion,
            'tipo' => $this->program->tipo,
            'modalidad' => $this->program->modalidad,
            'fecha_inicio' => $this->program->fecha_inicio,
            'fecha_final' => $this->program->fecha_final,
            'costo' => $this->program->costo,
            'hrs_academicas' => $this->program->hrs_academicas,
            'cantidad_modulos' => $this->program->cantidad_modulos,
            'esta_en_oferta' => $this->program->esta_en_oferta
        ];
        $this->programsTypes = ProgramsTypes::all();
        $this->modalities = Modality::all();
    }

    public function save()
    {
        $this->validate([
            'programArray.nombre' => 'required',
            'programArray.sigla' => 'required|string|max:20',
            'programArray.version' => 'required|string|max:20',
            'programArray.edicion' => 'required|string|max:20',
            'programArray.tipo' => 'required|string|max:50',
            'programArray.modalidad' => 'required|string|max:50',
            'programArray.fecha_inicio' => 'required|date',
            'programArray.fecha_final' => 'required|date',
            'programArray.costo' => 'required|numeric',
            'programArray.hrs_academicas' => 'required|integer',
            'programArray.cantidad_modulos' => 'required|integer',
        ], $this->message);
        ProgramService::update($this->programArray);
        return redirect()->route('program.show', $this->program->id);
    }

    public function render()
    {
        return view('livewire.academic.program.edit-program');
    }
}
