<?php

namespace App\Livewire\Academic\Teacher;

use App\Services\Academic\AreaTeacherService;
use App\Services\Academic\ContractService;
use App\Services\Academic\TeacherService;
use Livewire\Component;
use Livewire\WithPagination;

class ShowTeacher extends Component
{
    use WithPagination;
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
        $contracts = ContractService::getAllByTeacher($this->teacher->id);
        return view('livewire.academic.teacher.show-teacher', compact('contracts'));
    }
}
