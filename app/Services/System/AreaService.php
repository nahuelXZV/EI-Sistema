<?php

namespace App\Services\System;

use App\Models\Area;
use Spatie\Permission\Models\Permission;

class AreaService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $areas = Area::all();
        return $areas;
    }
};
