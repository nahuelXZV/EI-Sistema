<?php

namespace App\Livewire\Academic\AreaProfession;

use App\Services\Academic\AreaProfessionService;
use Livewire\Component;

class CreateAreaProfession extends Component
{
    public $breadcrumbs = [['title' => "Areas", "url" => "area-profession.list"], ['title' => "Crear", "url" => "area-profession.new"]];
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
        AreaProfessionService::create($this->areaArray);
        return redirect()->route('area-profession.list');
    }

    public function render()
    {
        return view('livewire.academic.area-profession.create-area-profession');
    }
}
