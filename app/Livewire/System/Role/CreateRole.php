<?php

namespace App\Livewire\System\Role;

use App\Services\System\PermissionService;
use App\Services\System\RoleService;
use Livewire\Component;

class CreateRole extends Component
{
    public $breadcrumbs = [['title' => "Roles", "url" => "role.list"], ['title' => "Crear", "url" => "role.create"]];
    public $nameRole;
    public $selectedPermissions = [];
    public $permissionsAcademic = [];
    public $permissionsAdministrative = [];
    public $permissionsAccountant = [];

    public $validate = [
        'nameRole' => 'required|unique:roles,name',
        'selectedPermissions' => 'required|array|min:1'
    ];

    public $messages = [
        'nameRole.required' => 'El campo nombre es requerido',
        'nameRole.unique' => 'El nombre ya existe',
        'selectedPermissions.required' => 'Debe seleccionar al menos un permiso',
        'selectedPermissions.array' => 'Debe seleccionar al menos un permiso',
        'selectedPermissions.min' => 'Debe seleccionar al menos un permiso'
    ];

    public function mount()
    {
        $this->permissionsAcademic = PermissionService::getAll('Académico');
        $this->permissionsAdministrative = PermissionService::getAll('Administrativo');
        $this->permissionsAccountant = PermissionService::getAll('Contabilidad');
    }

    public function save()
    {
        $this->validate($this->validate, $this->messages);
        $newListPermissions = [];
        foreach ($this->selectedPermissions as $key => $permiso) {
            if ($permiso) $newListPermissions[] = $key;
        }
        RoleService::create(
            $this->nameRole,
            $newListPermissions
        );
        return redirect()->route('role.list');
    }

    public function render()
    {
        return view('livewire.system.role.create-role');
    }
}
