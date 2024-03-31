<?php

namespace App\Constants;

class ListImport
{
    const STUDENT = "estudiante";
    const TEACHER = "docente";
    const PROGRAM = "programa";
    // const MODULE = "modulo";
    const COURSE = "curso";

    public static function all(): array
    {
        return [
            self::STUDENT,
            self::TEACHER,
            self::PROGRAM,
            self::COURSE,
            // self::MODULE,
        ];
    }
}
