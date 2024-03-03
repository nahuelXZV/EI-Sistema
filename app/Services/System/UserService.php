<?php

namespace App\Services\System;

use App\Models\User;

class UserService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $users = User::all();
        return $users;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $users = User::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('apellido', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('email', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $users;
    }

    static  public function getOne($id)
    {
        $user = User::find($id);
        return $user;
    }

    static public function create($data)
    {
        try {
            $new = User::create([
                'nombre' => $data['nombre'],
                'apellido' => $data['apellido'],
                'email' => $data['email'],
                'area_id' => $data['area_id'],
                'cargo_id' => $data['cargo_id'],
                'password' => bcrypt($data['password'])
            ]);
            $role = RoleService::getOne($data['role_id']);
            $new->assignRole($role->name);
            return $new;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function update($data)
    {
        try {
            $user = User::find($data['id']);
            $user->nombre = $data['nombre'];
            $user->apellido = $data['apellido'];
            $user->email = $data['email'];
            $user->area_id = $data['area_id'];
            $user->cargo_id = $data['cargo_id'];
            if ($data['password'] != '') {
                $user->password = bcrypt($data['password']);
            }
            $user->save();
            if ($user->roles[0]->id != $data['role_id']) {
                $role = RoleService::getOne($data['role_id']);
                $user->syncRoles([$role->name]);
            }
            return $user;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $user = User::find($id);
            $user->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
