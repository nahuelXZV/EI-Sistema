<?php

namespace App\Constants;

class Expedition
{
    const SC = "SC";
    const TJ = "TJ";
    const LP = "LP";
    const CH = "CH";
    const OR = "OR";
    const CB = "CB";
    const PT = "PT";
    const BE = "BE";
    const PD = "PD";

    // Agrega aquí más tipos de programas si es necesario

    public static function all(): array
    {
        return [
            self::SC,
            self::TJ,
            self::LP,
            self::CH,
            self::OR,
            self::CB,
            self::PT,
            self::BE,
            self::PD
            // Agrega aquí más tipos de programas si es necesario
        ];
    }
}
