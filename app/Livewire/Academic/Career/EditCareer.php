<?php

namespace App\Livewire\Academic\Career;

use App\Services\Academic\CareerService;
use Livewire\Component;

class EditCareer extends Component
{
    public $breadcrumbs = [['title' => "Carreras", "url" => "career.list"], ['title' => "Editar", "url" => "career.edit"]];
    public $careerArray = [];

    public $validate = [
        'careerArray.nombre' => 'required',

    ];

    public $message = [
        'careerArray.nombre.required' => 'El nombre es requerido',
    ];

    public function mount($career)
    {
        $careerEntity = CareerService::getOne($career);
        $this->careerArray = [
            'id' => $careerEntity->id,
            'nombre' => $careerEntity->nombre,
        ];
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        CareerService::update($this->careerArray);
        return redirect()->route('career.list');
    }

    public function render()
    {
        return view('livewire.academic.career.edit-career');
    }
}
