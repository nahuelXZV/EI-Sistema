<?php

namespace App\Constants;

class StateSupportRequest
{
    const PENDIENTE = "Pendiente";
    const ACEPTADO = "Aceptado";
    const RECHAZADO = "Rechazado";
    const POSPUESTO = "Pospuesto";

    public static function all(): array
    {
        return [
            self::PENDIENTE,
            self::ACEPTADO,
            self::RECHAZADO,
            self::POSPUESTO,
        ];
    }
}
