<?php

namespace App\Livewire\Inventory\Unit;

use App\Models\Unit;
use Livewire\Component;

class CreateUnit extends Component
{
    public $breadcrumbs = [['title' => "Unidades", "url" => "unit.list"], ['title' => "Crear", "url" => "unit.create"]];
    public $unitArray = [];

    public $validate = [
        'unitArray.nombre' => 'required',
    ];

    public $message = [
        'unitArray.nombre.required' => 'El nombre es requerido',
    ];

    public function mount()
    {
        $this->unitArray = [
            'nombre' => '',
        ];
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        Unit::create($this->unitArray);
        return redirect()->route('unit.list');
    }
    public function render()
    {
        return view('livewire.inventory.unit.create-unit');
    }
}
