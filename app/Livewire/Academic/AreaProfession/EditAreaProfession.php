<?php

namespace App\Livewire\Academic\AreaProfession;

use App\Services\Academic\AreaProfessionService;
use Livewire\Component;

class EditAreaProfession extends Component
{
    public $breadcrumbs = [['title' => "Areas", "url" => "area-profession.list"], ['title' => "Editar", "url" => "area-profession.edit"]];
    public $areaArray = [];

    public $validate = [
        'areaArray.nombre' => 'required',

    ];

    public $message = [
        'areaArray.nombre.required' => 'El nombre es requerido',
    ];

    public function mount($area)
    {
        $areaEntity = AreaProfessionService::getOne($area);
        $this->areaArray = [
            'id' => $areaEntity->id,
            'nombre' => $areaEntity->nombre,
        ];
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        AreaProfessionService::update($this->areaArray);
        return redirect()->route('area-profession.list');
    }

    public function render()
    {
        return view('livewire.academic.area-profession.edit-area-profession');
    }
}
