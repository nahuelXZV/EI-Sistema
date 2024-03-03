<?php

namespace App\Services\System;

use Spatie\Permission\Models\Permission;

class PermissionService
{
    public function __construct()
    {
    }

    static public function getAll($type = 'All')
    {
        if ($type == 'All') return  Permission::all();
        return  Permission::where('type', $type)->get();
    }
};
