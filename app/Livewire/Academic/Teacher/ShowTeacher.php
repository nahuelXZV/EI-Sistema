<?php

namespace App\Livewire\Academic\Teacher;

use App\Models\AreaTeacher;
use App\Services\Academic\AreaTeacherService;
use App\Services\Academic\TeacherService;
use Livewire\Component;

class ShowTeacher extends Component
{
    public $breadcrumbs = [['title' => "Docentes", "url" => "teacher.list"], ['title' => "Ver", "url" => "teacher.show"]];

    public $teacher;
    public $career;
    public $areas;

    public function mount($teacher)
    {
        $this->teacher = TeacherService::getOne($teacher);
        $this->career = $this->teacher->career;
        $this->areas = AreaTeacherService::getAllByTeacher($teacher);
    }

    public function changeFactura()
    {
        $this->teacher->factura = !$this->teacher->factura;
        $this->teacher->save();
    }

    public function delete($area)
    {
        AreaTeacherService::delete($area);
        $this->areas = AreaTeacherService::getAllByTeacher($this->teacher->id);
    }

    public function render()
    {
        return view('livewire.academic.teacher.show-teacher');
    }
}
