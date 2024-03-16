<?php

namespace App\Livewire\Academic\ModuleProcess;

use App\Services\Academic\ModuleProcessService;
use Livewire\Component;

class EditModuleProcess extends Component
{
    public $breadcrumbs = [['title' => "Procesos", "url" => "process.list"], ['title' => "Editar", "url" => "process.edit"]];
    public $processArray = [];

    public $validate = [
        'processArray.nombre' => 'required',

    ];

    public $message = [
        'processArray.nombre.required' => 'El nombre es requerido',
    ];

    public function mount($process)
    {
        $processEntity = ModuleProcessService::getOne($process);
        $this->processArray = [
            'id' => $processEntity->id,
            'nombre' => $processEntity->nombre,
        ];
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        ModuleProcessService::update($this->processArray);
        return redirect()->route('process.list');
    }

    public function render()
    {
        return view('livewire.academic.module-process.edit-module-process');
    }
}
