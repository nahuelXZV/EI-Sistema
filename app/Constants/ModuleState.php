<?php

namespace App\Constants;

class ModuleState
{
    const ACTIVO = "Activo";
    const INACTIVO = "Inactivo";
    const EN_PROCESO = "En proceso";
    const FINALIZADO = "Finalizado";
    const CANCELADO = "Cancelado";
    // Agrega aquí más tipos de programas si es necesario

    public static function all(): array
    {
        return [
            self::ACTIVO,
            self::INACTIVO,
            self::EN_PROCESO,
            self::FINALIZADO,
            self::CANCELADO,
            // Agrega aquí más tipos de programas si es necesario
        ];
    }
}
