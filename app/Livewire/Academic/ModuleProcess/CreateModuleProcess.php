<?php

namespace App\Livewire\Academic\ModuleProcess;

use App\Services\Academic\ModuleProcessService;
use Livewire\Component;

class CreateModuleProcess extends Component
{
    public $breadcrumbs = [['title' => "Procesos", "url" => "process.list"], ['title' => "Crear", "url" => "process.new"]];
    public $processArray = [];

    public $validate = [
        'processArray.nombre' => 'required',
    ];

    public $message = [
        'processArray.nombre.required' => 'El nombre es requerido',
    ];

    public function mount()
    {
        $this->processArray = [
            'nombre' => '',
        ];
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        ModuleProcessService::create($this->processArray);
        return redirect()->route('process.list');
    }

    public function render()
    {
        return view('livewire.academic.module-process.create-module-process');
    }
}
