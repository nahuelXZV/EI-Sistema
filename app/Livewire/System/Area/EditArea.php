<?php

namespace App\Livewire\System\Area;

use App\Services\System\AreaService;
use Livewire\Component;

class EditArea extends Component
{
    public $breadcrumbs = [['title' => "Areas", "url" => "area.list"], ['title' => "Editar", "url" => "area.edit"]];
    public $areaArray = [];

    public $validate = [
        'areaArray.nombre' => 'required',

    ];

    public $message = [
        'areaArray.nombre.required' => 'El nombre es requerido',
    ];

    public function mount($area)
    {
        $areaEntity = AreaService::getOne($area);
        $this->areaArray = [
            'id' => $areaEntity->id,
            'nombre' => $areaEntity->nombre,
        ];
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        AreaService::update($this->areaArray);
        return redirect()->route('area.list');
    }

    public function render()
    {
        return view('livewire.system.area.edit-area');
    }
}
