<?php

namespace App\Services\System;

use App\Models\Cargo;

class PositionService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $positions = Cargo::all();
        return $positions;
    }
};
