<?php

namespace App\Livewire\System\User;

use App\Services\System\AreaService;
use App\Services\System\PositionService;
use App\Services\System\RoleService;
use App\Services\System\UserService;
use Livewire\Component;

class EditUser extends Component
{
    public $breadcrumbs = [['title' => "Usuarios", "url" => "user.list"], ['title' => "Crear", "url" => "user.edit"]];
    public $userArray = [];

    public $roles = [];
    public $areas = [];
    public $positions = [];

    public $validate = [
        'userArray.nombre' => 'required',
        'userArray.apellido' => 'required',
        'userArray.email' => 'required|email',
        'userArray.password' => 'nullable',
        'userArray.role_id' => 'required',
        'userArray.area_id' => 'required',
        'userArray.cargo_id' => 'required',
    ];

    public $message = [
        'userArray.nombre.required' => 'El nombre es requerido',
        'userArray.apellido.required' => 'El apellido es requerido',
        'userArray.email.required' => 'El email es requerido',
        'userArray.email.email' => 'El email no es valido',
        'userArray.password.required' => 'La contraseña es requerida',
        'userArray.role_id.required' => 'El rol es requerido',
        'userArray.area_id.required' => 'El area es requerida',
        'userArray.cargo_id.required' => 'El cargo es requerido',
    ];

    public function mount($user)
    {
        $userEntity = UserService::getOne($user);
        $this->userArray = [
            'id' => $userEntity->id,
            'nombre' => $userEntity->nombre,
            'apellido' => $userEntity->apellido,
            'email' => $userEntity->email,
            'role_id' => $userEntity->roles[0]->id ?? null,
            'password' => '',
            'area_id' => $userEntity->area->id,
            'cargo_id' => $userEntity->cargo->id,
        ];
        $this->roles = RoleService::getAll();
        $this->areas = AreaService::getAll();
        $this->positions = PositionService::getAll();
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        UserService::update($this->userArray);
        return redirect()->route('user.list');
    }

    public function render()
    {
        return view('livewire.system.user.edit-user');
    }
}
