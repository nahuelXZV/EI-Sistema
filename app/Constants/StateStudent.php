<?php

namespace App\Constants;

class StateStudent
{
    const ACTIVE = "activo";
    const INACTIVE = "inactivo";
    const PENDING = "pendiente";
    const DELETED = "eliminado";
    // Agrega aquí más tipos de programas si es necesario

    public static function all(): array
    {
        return [
            self::ACTIVE,
            self::INACTIVE,
            self::PENDING,
            self::DELETED,
            // Agrega aquí más tipos de programas si es necesario
        ];
    }
}
