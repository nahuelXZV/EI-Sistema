<?php

namespace App\Livewire\Academic\Leader;

use App\Constants\Honorifics;
use App\Constants\Institutions;
use App\Constants\Position;
use App\Services\Academic\LeaderService;
use Livewire\Component;

class EditLeader extends Component
{
    public $breadcrumbs = [['title' => "Directivos", "url" => "leader.list"], ['title' => "Crear", "url" => "leader.new"]];
    public $leaderArray = [];
    public $honorificos = [];
    public $instituciones = [];
    public $positions = [];

    public $validate = [
        'leaderArray.honorifico' => 'required',
        'leaderArray.nombre' => 'required',
        'leaderArray.apellido' => 'required',
        'leaderArray.cargo' => 'required',
        'leaderArray.institucion' => 'required',
        'leaderArray.activo' => 'required',
    ];

    public $message = [
        'leaderArray.honorifico.required' => 'El honorifico es requerido',
        'leaderArray.nombre.required' => 'El nombre es requerido',
        'leaderArray.apellido.required' => 'El apellido es requerido',
        'leaderArray.cargo.required' => 'El cargo es requerido',
        'leaderArray.institucion.required' => 'La institución es requerida',
        'leaderArray.activo.required' => 'El estado es requerido',
    ];

    public function mount($leader)
    {
        $leader = LeaderService::getOne($leader);
        $this->leaderArray = [
            'id' => $leader->id,
            'honorifico' => $leader->honorifico,
            'nombre' => $leader->nombre,
            'apellido' => $leader->apellido,
            'cargo' => $leader->cargo,
            'institucion' => $leader->institucion,
            'activo' => $leader->activo,
        ];
        $this->honorificos = Honorifics::all();
        $this->instituciones = Institutions::all();
        $this->positions = Position::all();
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        LeaderService::update($this->leaderArray);
        return redirect()->route('leader.list');
    }

    public function render()
    {
        return view('livewire.academic.leader.edit-leader');
    }
}
