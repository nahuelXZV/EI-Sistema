<?php

namespace App\Services\System;

use Spatie\Permission\Models\Role;

class RoleService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $roles = Role::all();
        return $roles;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $roles = Role::where('name', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $roles;
    }

    static  public function getOne($id)
    {
        $role = Role::find($id);
        return $role;
    }

    static public function create($role, $permissions)
    {
        try {
            $role = Role::create(['name' => $role, 'guard_name' => 'web']);
            $role->syncPermissions($permissions);
            $role->save();
            return $role;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function update($id, $name, $permissions)
    {
        try {
            $role = Role::find($id);
            if ($role->name != $name) {
                $role->name = $name;
            }
            $role->syncPermissions($permissions);
            $role->save();
            return $role;
        } catch (\Exception $e) {
            return false;
        }
    }

    static  public function delete($role)
    {
        try {
            $role = Role::find($role);
            $role->delete();
            return $role;
        } catch (\Exception $e) {
            return false;
        }
    }
};
