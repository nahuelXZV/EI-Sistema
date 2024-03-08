<?php

namespace App\Livewire\System\Role;

use App\Services\System\PermissionService;
use App\Services\System\RoleService;
use Livewire\Component;

class EditRole extends Component
{
    public $breadcrumbs = [['title' => "Roles", "url" => "role.list"], ['title' => "Editar", "url" => "role.edit"]];
    public $roleName;
    public $roleId;
    public $selectedPermissions = [];
    public $permissionsAcademic = [];
    public $permissionsAdministrative = [];
    public $permissionsAccountant = [];

    public $messages = [
        'roleName.required' => 'El campo nombre es requerido',
        'roleName.unique' => 'El nombre ya existe',
        'selectedPermissions.required' => 'Debe seleccionar al menos un permiso',
        'selectedPermissions.array' => 'Debe seleccionar al menos un permiso',
        'selectedPermissions.min' => 'Debe seleccionar al menos un permiso'
    ];

    public function mount($role)
    {
        $role = RoleService::getOne($role);
        $this->roleName = $role->name;
        $this->roleId = $role->id;
        $permissionRole =  $role->getAllPermissions();
        foreach ($permissionRole as $permission) {
            $this->selectedPermissions[$permission->id] = true;
        }
        $this->permissionsAcademic = PermissionService::getAll('Académico');
        $this->permissionsAdministrative = PermissionService::getAll('Administrativo');
        $this->permissionsAccountant = PermissionService::getAll('Contabilidad');
    }
    public function save()
    {
        $this->validate([
            'roleName' => 'required|unique:roles,name,' . $this->roleId,
            'selectedPermissions' => 'required|array|min:1'
        ], $this->messages);
        $newListPermissions = [];
        foreach ($this->selectedPermissions as $key => $permiso) {
            if ($permiso) $newListPermissions[] = $key;
        }
        RoleService::update(
            $this->roleId,
            $this->roleName,
            $newListPermissions
        );
        return redirect()->route('role.list');
    }

    public function render()
    {
        return view('livewire.system.role.edit-role');
    }
}
