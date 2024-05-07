<?php

namespace App\Constants;

class ProgramPaymentStatus
{
    const PENDING = "Pendiente";
    const PAYING = "Pagando";
    const PAID = "Pagado";
    const CANCELED = "Cancelado";
    const REFUNDED = "Reembolsado";

    public static function all(): array
    {
        return [
            self::PENDING,
            self::PAYING,
            self::PAID,
            self::CANCELED,
            self::REFUNDED,
        ];
    }
}
