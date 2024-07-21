<?php

namespace App\Constants;

class StateInventoryRequest
{
    const PENDIENTE = "Pendiente";
    const APROBADO = "Aprobado";
    const RECHAZADO = "Rechazado";

    public static function all(): array
    {
        return [
            self::PENDIENTE,
            self::APROBADO,
            self::RECHAZADO,
        ];
    }
}
