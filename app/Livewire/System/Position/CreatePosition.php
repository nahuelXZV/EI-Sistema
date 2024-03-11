<?php

namespace App\Livewire\System\Position;

use App\Services\System\PositionService;
use Livewire\Component;

class CreatePosition extends Component
{
    public $breadcrumbs = [['title' => "Cargos", "url" => "position.list"], ['title' => "Crear", "url" => "position.create"]];
    public $positionArray = [];

    public $validate = [
        'positionArray.nombre' => 'required',
    ];

    public $message = [
        'positionArray.nombre.required' => 'El nombre es requerido',
    ];

    public function mount()
    {
        $this->positionArray = [
            'nombre' => '',
        ];
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        PositionService::create($this->positionArray);
        return redirect()->route('position.list');
    }

    public function render()
    {
        return view('livewire.system.position.create-position');
    }
}
