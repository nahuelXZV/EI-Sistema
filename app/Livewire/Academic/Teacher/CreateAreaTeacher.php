<?php

namespace App\Livewire\Academic\Teacher;

use App\Services\Academic\AreaProfessionService;
use App\Services\Academic\AreaTeacherService;
use App\Services\Academic\TeacherService;
use Livewire\Component;

class CreateAreaTeacher extends Component
{
    public $breadcrumbs = [];
    public $teacher;
    public $areas;
    public $area;

    public $validate = [
        'area' => 'required|integer'
    ];

    public $message = [
        'area.required' => 'El área es requerida',
        'area.integer' => 'El área debe ser un número entero'
    ];

    public function mount($teacher)
    {
        $this->teacher = TeacherService::getOne($teacher);
        $this->areas = AreaProfessionService::getAll();
        $nameTeacher = $this->teacher->nombre . ' ' . $this->teacher->apellido;
        $this->breadcrumbs = [
            ['title' => "Docentes", "url" => "teacher.list"],
            ['title' => $nameTeacher, "url" => "teacher.show", "id" => $teacher],
            ['title' => "Crear Área", "url" => "teacher.create.area", "id" => $teacher]
        ];
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        AreaTeacherService::create([
            'docente_id' => $this->teacher->id,
            'area_id' => $this->area
        ]);
        return redirect()->route('teacher.show', $this->teacher->id);
    }

    public function render()
    {
        return view('livewire.academic.teacher.create-area-teacher');
    }
}
