<?php

namespace App\Livewire\Academic\University;

use App\Services\Academic\UniversityService;
use Livewire\Component;

class EditUniversity extends Component
{
    public $breadcrumbs = [['title' => "Universidades", "url" => "university.list"], ['title' => "Editar", "url" => "university.create"]];
    public $universityArray = [];

    public $validate = [
        'universityArray.nombre' => 'required',

    ];

    public $message = [
        'universityArray.nombre.required' => 'El nombre es requerido',
    ];

    public function mount($university)
    {
        $universityEntity = UniversityService::getOne($university);
        $this->universityArray = [
            'id' => $universityEntity->id,
            'nombre' => $universityEntity->nombre,
        ];
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        UniversityService::update($this->universityArray);
        return redirect()->route('university.list');
    }


    public function render()
    {
        return view('livewire.academic.university.edit-university');
    }
}
