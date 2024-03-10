<?php

namespace App\Constants;

class Honorifics
{
    const DR = "Dr.";
    const PROF = "Prof.";
    const ING = "Ing.";
    const LIC = "Lic.";
    const TEC = "Tec.";
    const ARQ = "Arq.";
    const MSC = "MSc.";
    const PHD = "PhD.";

    // Agrega aquí más tipos de programas si es necesario

    public static function all(): array
    {
        return [
            self::DR,
            self::PROF,
            self::ING,
            self::LIC,
            self::TEC,
            self::ARQ,
            self::MSC,
            self::PHD,
            // Agrega aquí más tipos de programas si es necesario
        ];
    }
}
