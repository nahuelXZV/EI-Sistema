<?php

namespace App\Constants;

class ListImport
{
    const STUDENT = "estudiante";
    const TEACHER = "docente";
    const PROGRAM = "programa";
    // const MODULE = "modulo";
    const COURSE = "curso";
    const INVENTORY = "inventario";
    const FIXED_ASSET = "activo fijos";

    public static function all(): array
    {
        return [
            self::STUDENT,
            self::TEACHER,
            self::PROGRAM,
            self::COURSE,
            self::INVENTORY,
            self::FIXED_ASSET,
            // self::MODULE,
        ];
    }
}
