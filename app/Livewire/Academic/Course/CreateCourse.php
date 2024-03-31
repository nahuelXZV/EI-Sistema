<?php

namespace App\Livewire\Academic\Course;

use App\Constants\Modality;
use App\Services\Academic\CourseService;
use App\Services\Academic\TeacherService;
use Livewire\Component;

class CreateCourse extends Component
{
    public $breadcrumbs = [['title' => "Cursos", "url" => "course.list"], ['title' => "Crear", "url" => "course.create"]];
    public $courseArray = [];
    public $modalities = [];
    public $filterTeacher = '';

    public $validate = [
        'courseArray.nombre' => 'required',
        'courseArray.horario' => 'required',
        'courseArray.hrs_academicas' => 'required|integer',
        'courseArray.costo' => 'required|numeric',
        'courseArray.modalidad' => 'required|string|max:50',
        'courseArray.fecha_inicio' => 'required|date',
        'courseArray.fecha_final' => 'required|date',
        'courseArray.docente_id' => 'required|integer',
    ];

    public $message = [
        'courseArray.nombre.required' => 'El nombre es requerido',
        'courseArray.horario.required' => 'El horario es requerido',
        'courseArray.hrs_academicas.required' => 'Las horas académicas son requeridas',
        'courseArray.hrs_academicas.integer' => 'Las horas académicas deben ser un número entero',
        'courseArray.costo.required' => 'El costo es requerido',
        'courseArray.costo.numeric' => 'El costo debe ser un número',
        'courseArray.modalidad.required' => 'La modalidad es requerida',
        'courseArray.modalidad.string' => 'La modalidad debe ser un texto',
        'courseArray.modalidad.max' => 'La modalidad debe tener máximo 50 caracteres',
        'courseArray.fecha_inicio.required' => 'La fecha de inicio es requerida',
        'courseArray.fecha_inicio.date' => 'La fecha de inicio debe ser una fecha',
        'courseArray.fecha_final.required' => 'La fecha final es requerida',
        'courseArray.fecha_final.date' => 'La fecha final debe ser una fecha',
        'courseArray.docente_id.required' => 'El docente es requerido',
        'courseArray.docente_id.integer' => 'El docente debe ser un número entero',
    ];


    public function mount()
    {
        $this->courseArray = [
            'nombre' => '',
            'horario' => '',
            'hrs_academicas' => 0,
            'costo' => 0,
            'modalidad' => '',
            'fecha_inicio' => '',
            'fecha_final' => '',
            'docente_id' => '',
        ];
        $this->modalities = Modality::all();
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        CourseService::create($this->courseArray);
        return redirect()->route('course.list');
    }

    public function render()
    {
        $teachers = TeacherService::getAllByNameAndCi($this->filterTeacher);
        return view('livewire..academic.course.create-course',compact('teachers'));
    }
}