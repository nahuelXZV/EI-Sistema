<?php

namespace App\Livewire\System\Position;

use App\Services\System\PositionService;
use Livewire\Component;

class EditPosition extends Component
{
    public $breadcrumbs = [['title' => "Cargos", "url" => "position.list"], ['title' => "Editar", "url" => "position.edit"]];
    public $positionArray = [];

    public $validate = [
        'positionArray.nombre' => 'required',

    ];

    public $message = [
        'positionArray.nombre.required' => 'El nombre es requerido',
    ];

    public function mount($position)
    {
        $positionEntity = PositionService::getOne($position);
        $this->positionArray = [
            'id' => $positionEntity->id,
            'nombre' => $positionEntity->nombre,
        ];
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        PositionService::update($this->positionArray);
        return redirect()->route('position.list');
    }


    public function render()
    {
        return view('livewire.system.position.edit-position');
    }
}
