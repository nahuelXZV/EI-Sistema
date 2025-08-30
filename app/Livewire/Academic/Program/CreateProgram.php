<?php

namespace App\Livewire\Academic\Program;

use App\Constants\Modality;
use App\Constants\ProgramsTypes;
use App\Services\Academic\ProgramService;
use Livewire\Component;

class CreateProgram extends Component
{
    public $breadcrumbs = [['title' => "Programas", "url" => "program.list"], ['title' => "Crear", "url" => "program.create"]];
    public $programArray = [];
    public $programsTypes = [];
    public $modalities = [];

    public $validate = [
        'programArray.codigo' => 'unique:program,codigo',
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
    ];

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


    public function mount()
    {
        $this->programArray = [
            'codigo' => '',
            'nombre' => '',
            'sigla' => '',
            'version' => '',
            'edicion' => '',
            'tipo' => '',
            'modalidad' => '',
            'fecha_inicio' => '',
            'fecha_final' => '',
            'costo' => '',
            'hrs_academicas' => '',
            'cantidad_modulos' => '',
        ];
        $this->programsTypes = ProgramsTypes::all();
        $this->modalities = Modality::all();
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        ProgramService::create($this->programArray);
        return redirect()->route('program.list');
    }

    public function render()
    {
        return view('livewire.academic.program.create-program');
    }
}
