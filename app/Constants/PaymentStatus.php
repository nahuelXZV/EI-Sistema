<?php

namespace App\Constants;

class PaymentStatus
{
    const WITHDEBT = "CON DEUDA";
    const NODEBT = "SIN DEUDA";
    const PENDING = "PENDIENTE";
    const PAID = "PAGADO";

    public static function all(): array
    {
        return [
            self::PENDING,
            self::PAID,
            self::WITHDEBT,
            self::NODEBT,
        ];
    }
}
