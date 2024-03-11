<?php

namespace App\Livewire\Academic\University;

use App\Services\Academic\UniversityService;
use Livewire\Component;

class CreateUniversity extends Component
{
    public $breadcrumbs = [['title' => "Universidades", "url" => "university.list"], ['title' => "Crear", "url" => "university.create"]];
    public $universityArray = [];

    public $validate = [
        'universityArray.nombre' => 'required',
    ];

    public $message = [
        'universityArray.nombre.required' => 'El nombre es requerido',
    ];

    public function mount()
    {
        $this->universityArray = [
            'nombre' => '',
        ];
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        UniversityService::create($this->universityArray);
        return redirect()->route('university.list');
    }

    public function render()
    {
        return view('livewire.academic.university.create-university');
    }
}
