<?php

namespace App\Constants;

class InventoryFilter
{
    const TODOS = "Todos";
    const STOCK_CERO = "Stock Cero";
    const STOCK_MAYOR_CERO = "Stock Mayor a Cero";

    public static function all(): array
    {
        return [
            self::TODOS,
            self::STOCK_CERO,
            self::STOCK_MAYOR_CERO,
        ];
    }
}
