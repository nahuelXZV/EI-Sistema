<?php

namespace App\Constants;

class Institutions
{
    const ESCUELAINGENIERIAFCET = "Escuela de Ingeniería - F.C.E.T";
    const ESCUELAINGENIERIAUAGRM = "Escuela de Ingeniería - U.A.G.R.M";
    const FCETUAGRM = "F.C.E.T - U.A.G.R.M";
    const JAF = "JAF";
    const UAGRM = "UAGRM";
    const FCET = "FCET";
    const CONSEJODIRECTIVO = "Consejo directivo de postgrado";
    const ESCUELAINGENIERIA = "Escuela de Ingeniería";
    // Agrega aquí más tipos de programas si es necesario

    public static function all(): array
    {
        return [
            self::ESCUELAINGENIERIA,
            self::ESCUELAINGENIERIAFCET,
            self::ESCUELAINGENIERIAUAGRM,
            self::FCETUAGRM,
            self::JAF,
            self::UAGRM,
            self::FCET,
            self::CONSEJODIRECTIVO
            // Agrega aquí más tipos de programas si es necesario
        ];
    }
}
