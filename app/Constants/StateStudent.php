<?php

namespace App\Constants;

class StateStudent
{
    const ACTIVE = "Activo";
    const INACTIVE = "Inactivo";
    const PENDING = "Pendiente";
    const DELETED = "Eliminado";
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
