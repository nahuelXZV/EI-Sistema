<?php

namespace App\Constants;

class StateFixedAsset
{
    const FUNCIONAL = "Funcional";
    const DE_BAJA = "De baja";


    public static function all(): array
    {
        return [
            self::FUNCIONAL,
            self::DE_BAJA,

        ];
    }
}
