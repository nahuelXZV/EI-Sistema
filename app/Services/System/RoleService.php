<?php

namespace App\Services\System;

use Spatie\Permission\Models\Role;

class RoleService
{
    public function __construct()
    {
    }

    static public function getAll($attribute, $paginate, $order = "desc")
    {
        $users = Role::where('name', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $users;
    }

    static  public function getOne($id)
    {
        $role = Role::find($id);
        return $role;
    }

    static public function create($role, $permissions)
    {
        $role = Role::create(['name' => $role, 'guard_name' => 'web']);
        $role->syncPermissions($permissions);
        return $role;
    }

    static public function update(Role $role, $permissions)
    {
        $role->syncPermissions($permissions);
        return $role;
    }

    static  public function delete($role)
    {
        $role->delete();
        return $role;
    }
};
