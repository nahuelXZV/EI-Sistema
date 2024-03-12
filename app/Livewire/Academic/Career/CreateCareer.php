<?php

namespace App\Livewire\Academic\Career;

use App\Services\Academic\CareerService;
use Livewire\Component;

class CreateCareer extends Component
{
    public $breadcrumbs = [['title' => "Carreras", "url" => "career.list"], ['title' => "Crear", "url" => "career.new"]];
    public $careerArray = [];

    public $validate = [
        'careerArray.nombre' => 'required',
    ];

    public $message = [
        'careerArray.nombre.required' => 'El nombre es requerido',
    ];

    public function mount()
    {
        $this->careerArray = [
            'nombre' => '',
        ];
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        CareerService::create($this->careerArray);
        return redirect()->route('career.list');
    }

    public function render()
    {
        return view('livewire.academic.career.create-career');
    }
}
