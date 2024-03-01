<?php

namespace App\Services\System;

use App\Models\User;

class UserService
{
    public function __construct()
    {
    }

    static public function getAll($attribute, $paginate, $order = "desc")
    {
        $users = User::where('name', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('email', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $users;
    }

    static  public function getOne()
    {
        return 'User';
    }

    static public function create()
    {
        return 'User saved';
    }

    static public function update()
    {
        return 'User updated';
    }

    static  public function delete()
    {
        return 'User deleted';
    }
};
