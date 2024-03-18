<?php

namespace App\Livewire\Academic\Teacher;

use App\Services\Academic\TeacherService;
use Livewire\Component;

class ShowTeacher extends Component
{
    public $breadcrumbs = [['title' => "Docentes", "url" => "teacher.list"], ['title' => "Ver", "url" => "teacher.show"]];

    public $teacher;

    public function mount($teacher)
    {
        $this->teacher = TeacherService::getOne($teacher);
    }

    public function changeFactura()
    {
        $this->teacher->factura = !$this->teacher->factura;
        $this->teacher->save();
    }

    public function render()
    {
        return view('livewire.academic.teacher.show-teacher');
    }
}
