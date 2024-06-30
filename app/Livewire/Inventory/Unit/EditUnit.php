<?php

namespace App\Livewire\Inventory\Unit;

use App\Services\Inventory\UnitService;
use Livewire\Component;

class EditUnit extends Component
{
    public $breadcrumbs = [['title' => "Unidades", "url" => "unit.list"], ['title' => "Editar", "url" => "unit.edit"]];
    public $unitArray = [];

    public $validate = [
        'unitArray.nombre' => 'required',
    ];

    public $message = [
        'unitArray.nombre.required' => 'El nombre es requerido',
    ];

    public function mount($unit)
    {
        $unit = UnitService::getOne($unit);
        $this->unitArray = [
            'id' => $unit->id,
            'nombre' => $unit->nombre,
        ];
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        UnitService::update($this->unitArray);
        return redirect()->route('unit.list');
    }

    public function render()
    {
        return view('livewire.inventory.unit.edit-unit');
    }
}
