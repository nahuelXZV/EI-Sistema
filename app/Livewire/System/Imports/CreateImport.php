<?php

namespace App\Livewire\System\Imports;

use App\Constants\ListImport;
use App\Imports\CourseImport;
use App\Imports\InventoryImport;
use App\Imports\ProgramImport;
use App\Imports\StudentImport;
use App\Imports\TeacherImport;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class CreateImport extends Component
{
    use WithFileUploads;
    protected $listeners = ['cleanerNotificacion'];
    public $breadcrumbs = [['title' => "Importar", "url" => "imports"]];

    public $file;
    public $listModels;
    public $modelSelected;

    public $notificacion = false;
    public $type = '';
    public $message = '';

    public $validate = [
        'modelSelected' => 'required|string',
        'file' => 'required|mimes:xlsx',
    ];

    public $messages = [
        'file.required' => 'El archivo es requerido',
        'file.mimes' => 'El archivo debe ser un archivo de excel',
        'modelSelected' => 'El tipo es requerido'
    ];

    public function mount()
    {
        $this->file = null;
        $this->listModels = ListImport::all();
    }

    public function cleanerNotificacion()
    {
        $this->notificacion = null;
        $this->type = '';
        $this->message = '';
    }

    public function import()
    {
        $this->validate($this->validate, $this->message);
        try {
            if ($this->modelSelected == ListImport::TEACHER)
                Excel::import(new TeacherImport, $this->file);
            if ($this->modelSelected == ListImport::STUDENT)
                Excel::import(new StudentImport, $this->file);
            if ($this->modelSelected == ListImport::PROGRAM)
                Excel::import(new ProgramImport, $this->file);
            if ($this->modelSelected == ListImport::COURSE)
                Excel::import(new CourseImport, $this->file);
            if ($this->modelSelected == ListImport::INVENTORY)
                Excel::import(new InventoryImport, $this->file);
            $this->notificacion = true;
            $this->type = 'success';
            $this->message = 'Migracion realizada exitosamente!';
            $this->file = null;
            $this->modelSelected = null;
        } catch (\Throwable $th) {
            $this->notificacion = true;
            $this->type = 'error';
            // $this->message = "No se puede importar, verifique el archivo";
            $this->message = $th->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.system.imports.create-import');
    }
}
