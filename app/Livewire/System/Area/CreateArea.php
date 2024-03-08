<?php

namespace App\Livewire\System\Area;

use App\Services\System\AreaService;
use Livewire\Component;

class CreateArea extends Component
{
    public $breadcrumbs = [['title' => "Areas", "url" => "area.list"], ['title' => "Crear", "url" => "area.create"]];
    public $areaArray = [];

    public $validate = [
        'areaArray.nombre' => 'required',
    ];

    public $message = [
        'areaArray.nombre.required' => 'El nombre es requerido',
    ];

    public function mount()
    {
        $this->areaArray = [
            'nombre' => '',
        ];
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        AreaService::create($this->areaArray);
        return redirect()->route('area.list');
    }

    public function render()
    {
        return view('livewire.system.area.create-area');
    }
}
